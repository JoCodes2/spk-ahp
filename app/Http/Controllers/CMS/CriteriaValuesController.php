<?php

namespace App\Http\Controllers\CMS;

use App\Http\Requests\CriteriaValuesRequest;
use App\Models\CriteriaValues;
use App\Repositories\CriteriaValuesRepositories;
use Illuminate\Http\Request;

class CriteriaValuesController
{
    protected $criteriaVeluesRepo;
    public function __construct(CriteriaValuesRepositories $criteraValuesRepo)
    {
        $this->criteriaVeluesRepo = $criteraValuesRepo;
    }
    public function getAllData()
    {
        return $this->criteriaVeluesRepo->getAlldata();
    }
    public function createData(CriteriaValuesRequest $request)
    {
        return $this->criteriaVeluesRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->criteriaVeluesRepo->getDataById($id);
    }
    public function updateData(CriteriaValuesRequest $request,  $id)
    {
        return $this->criteriaVeluesRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->criteriaVeluesRepo->deleteData($id);
    }
}
