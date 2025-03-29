<?php

namespace App\Repositories;

use App\Http\Requests\ApplicantRequest;
use App\Interface\ApplicantInterfaces;
use App\Interface\ApplicantScoresInterfaces;
use App\Models\ApplicantScores;
use App\Traits\HttpResponseTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicantScoresRepositories implements ApplicantScoresInterfaces
{
    use HttpResponseTraits;
    protected $appScores;
    public function __construct(ApplicantScores $appScores)
    {
        $this->appScores = $appScores;
    }
    public function getAllData()
    {
        try {
            $data = $this->appScores::with('applicant', 'criteriaValue')->get();
            return $this->success($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createData(Request $request)
    {
        try {
            $values = $request->input('values');

            $insertData = [];

            foreach ($values as $applicantId => $criteriaScores) {
                foreach ($criteriaScores as $criteriaId => $score) {
                    if ($score !== null) {
                        $insertData[] = [
                            'id' => Str::uuid(),
                            'applicant_id' => $applicantId,
                            'criteria_value_id' => $criteriaId,
                            'score' => $score,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            if (!empty($insertData)) {
                $this->appScores::insert($insertData);
            }
            return $this->success();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteAll()
    {
        try {
            DB::table('applicant_scores')->truncate();
            return $this->delete();
        } catch (\Exception $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
