<?php

namespace App\Interface;

use App\Http\Requests\CriteriaValuesRequest;

interface CriteriaValuesInterfaces
{
    public function getAllData();
    public function createData(CriteriaValuesRequest $request);
    public function getDataById($id);
    public function updateData(CriteriaValuesRequest $request,  $id);
    public function deleteData($id);
}
