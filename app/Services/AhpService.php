<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Criteria;
use App\Models\Applicant;
use App\Models\ApplicantScore;
use App\Models\ApplicantScores;
use App\Models\CriteriaValues;
use App\Models\ResultAHP;

class AhpService
{
    public function calculateAHP()
    {
        $criteria = Cache::remember('ahp_criteria', now()->addMinutes(30), function () {
            return Criteria::all();
        });

        $applicants = Cache::remember('ahp_applicants', now()->addMinutes(30), function () {
            return Applicant::all();
        });

        $scores = Cache::remember('ahp_scores', now()->addMinutes(30), function () {
            return ApplicantScores::all();
        });

        if ($criteria->isEmpty() || $applicants->isEmpty() || $scores->isEmpty()) {
            return ['status' => 'error', 'message' => 'Data tidak lengkap!'];
        }

        // 1. Matriks Perbandingan Kriteria
        $comparisonMatrix = $this->createComparisonMatrix($criteria);
        Cache::put('ahp_comparison_matrix', $comparisonMatrix, now()->addMinutes(30));

        // 2. Normalisasi Matriks
        $normalizedMatrix = $this->normalizeMatrix($comparisonMatrix);
        Cache::put('ahp_normalized_matrix', $normalizedMatrix, now()->addMinutes(30));

        // 3. Menghitung Bobot Prioritas
        $weights = $this->calculateWeights($normalizedMatrix);
        Cache::put('ahp_weights', $weights, now()->addMinutes(30));

        // 4. Menghitung Consistency Ratio
        $consistencyRatio = $this->calculateConsistencyRatio($comparisonMatrix, $weights);
        Cache::put('ahp_consistency_ratio', $consistencyRatio, now()->addMinutes(30));

        if ($consistencyRatio > 0.1) {
            return ['status' => 'error', 'message' => 'Consistency Ratio terlalu tinggi!'];
        }

        // 5. Matriks Keputusan (Alternatif terhadap Kriteria)
        $decisionMatrix = $this->createDecisionMatrix($applicants, $scores);
        Cache::put('ahp_decision_matrix', $decisionMatrix, now()->addMinutes(30));

        // 6. Menghitung Bobot Akhir Alternatif
        $finalScores = $this->calculateFinalScores($decisionMatrix, $weights);

        return $finalScores;
    }

    private function createComparisonMatrix($criteria)
    {
        $criteriaValues = CriteriaValues::whereIn('criteria_id', $criteria->pluck('id'))->get();
        if ($criteriaValues->isEmpty()) {
            throw new \Exception("Tidak ada data kriteria yang tersedia.");
        }

        $criteriaWeights = $criteriaValues->pluck('weight', 'criteria_id')->toArray();
        $criteriaKeys = array_keys($criteriaWeights);
        $n = count($criteriaKeys);
        $matrix = [];

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $matrix[$i][$j] = $i === $j ? 1 : ($criteriaWeights[$criteriaKeys[$i]] / $criteriaWeights[$criteriaKeys[$j]]);
            }
        }
        return $matrix;
    }

    private function normalizeMatrix($matrix)
    {
        $n = count($matrix);
        $columnSums = array_fill(0, $n, 0);

        foreach ($matrix as $row) {
            foreach ($row as $j => $value) {
                $columnSums[$j] += $value;
            }
        }

        $normalizedMatrix = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $value) {
                $normalizedMatrix[$i][$j] = $columnSums[$j] ? ($value / $columnSums[$j]) : 0;
            }
        }
        return $normalizedMatrix;
    }

    private function calculateWeights($normalizedMatrix)
    {
        return array_map(fn($row) => array_sum($row) / count($row), $normalizedMatrix);
    }

    private function calculateConsistencyRatio($comparisonMatrix, $weights)
    {
        $n = count($weights);
        $lambdaMax = array_sum(array_map(fn($row, $w) => array_sum(array_map(fn($v, $w2) => $v * $w2, $row, $weights)) / $w, $comparisonMatrix, $weights)) / $n;

        $ci = ($lambdaMax - $n) / ($n - 1);
        $ri = [0, 0, 0.58, 0.9, 1.12, 1.24][$n - 1] ?? 1.24;
        return $ci / $ri;
    }

    private function createDecisionMatrix($applicants, $scores)
    {
        $matrix = [];
        foreach ($applicants as $applicant) {
            $matrix[$applicant->id] = [];
            foreach ($scores->where('applicant_id', $applicant->id) as $score) {
                $matrix[$applicant->id][$score->criteria_value_id] = $score->score;
            }
        }
        return $matrix;
    }

    private function calculateFinalScores($decisionMatrix, $weights)
    {
        $finalScores = [];
        foreach ($decisionMatrix as $applicantId => $scores) {
            $finalScores[$applicantId] = array_sum(array_map(fn($score, $w) => $score * $w, array_values($scores), $weights));
        }

        arsort($finalScores);
        $rank = 1;
        foreach ($finalScores as $applicantId => $score) {
            $finalScores[$applicantId] = ['final_score' => $score, 'rank' => $rank++];
        }
        return [
            'status' => 'success',
            'data' => $finalScores
        ];
    }
}
