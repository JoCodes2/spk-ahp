<?php

namespace App\Repositories;

use App\Http\Requests\CriteriaValuesRequest;
use App\Interface\CriteriaValuesInterfaces;
use App\Models\CriteriaValues;
use App\Traits\HttpResponseTraits;

class CriteriaValuesRepositories implements CriteriaValuesInterfaces
{
    use HttpResponseTraits;
    protected $criteriaValModel;
    public function __construct(CriteriaValues $criteriaValModel)
    {
        $this->criteriaValModel = $criteriaValModel;
    }
    public function getAlldata()
    {
        $data = $this->criteriaValModel::with('criteria')->get();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function createData(CriteriaValuesRequest $request)
    {
        try {
            $data = $this->criteriaValModel->create($request->all());
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function getDataById($id)
    {
        $data = $this->criteriaValModel::with('criteria')->find($id);
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
    public function updateData(CriteriaValuesRequest $request,  $id)
    {
        try {
            $data = $this->criteriaValModel::find($id);
            if (!$data) {
                return $this->dataNotFound();
            }
            $data->update($request->all());
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
    public function deleteData($id)
    {
        try {
            $data = $this->criteriaValModel::find($id);
            if (!$data) {
                return $this->dataNotFound();
            }
            $data->delete();
            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
