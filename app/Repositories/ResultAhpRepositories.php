<?php

namespace App\Repositories;

use App\Interface\ResultAhpIterfaces;
use App\Models\Applicant;
use App\Models\ResultAHP;
use App\Services\AhpService;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResultAhpRepositories implements ResultAhpIterfaces
{
    use HttpResponseTraits;
    protected $resultAhpModel;
    protected $ahpService;

    public function __construct(ResultAHP $resultAhpModel, AhpService $ahpService)
    {
        $this->resultAhpModel = $resultAhpModel;
        $this->ahpService = $ahpService;
    }

    public function getAllData()
    {
        $resultData = $this->resultAhpModel::all();
        $comparisonMatrix = Cache::get('ahp_comparison_matrix', []);
        $normalizedMatrix = Cache::get('ahp_normalized_matrix', []);
        $weights = Cache::get('ahp_weights', []);
        $consistencyRatio = Cache::get('ahp_consistency_ratio', 0);
        $decisionMatrix = Cache::get('ahp_decision_matrix', []);

        $response = [
            'status' => 'success',
            'result_data' => $resultData,
            'comparison_matrix' => $comparisonMatrix,
            'normalized_matrix' => $normalizedMatrix,
            'weights' => $weights,
            'consistency_ratio' => $consistencyRatio,
            'decision_matrix' => $decisionMatrix,
        ];

        return $this->success($response);
    }


    public function createData(Request $request)
    {
        $result = $this->ahpService->calculateAHP();

        if ($result['status'] === 'error') {
            return $this->error($result['message'], 400);
        }
        $finalScores = $result['data'];

        $this->resultAhpModel::truncate();

        foreach ($finalScores as $applicantId => $scoreData) {
            $applicant = Applicant::find($applicantId);

            if (!$applicant) {
                continue;
            }

            $this->resultAhpModel::create([
                'id' => Str::uuid(),
                'applicant_name' => $applicant->name,
                'applicant_position' => $applicant->position->name,
                'final_score' => $scoreData['final_score'],
                'rank' => $scoreData['rank']
            ]);
        }

        return $this->success('Perhitungan AHP berhasil disimpan!');
    }

    public function arsipData()
    {
        try {
            $tablesToKeep = ['criteria', 'ahp_result'];
            $tables = DB::select('SHOW TABLES');

            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            foreach ($tables as $table) {
                $tableName = reset($table);
                if (!in_array($tableName, $tablesToKeep)) {
                    DB::table($tableName)->truncate();
                }
            }
            Cache::flush();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            return $this->success('Data arsip berhasil!');
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
