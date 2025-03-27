<?php

namespace App\Http\Controllers\CMS;

use App\Http\Requests\PositionRequest;
use App\Repositories\PositionRepositories;
use Illuminate\Http\Request;

class PositionController
{
    protected $PositionRepo;
    public function __construct(PositionRepositories $PositionRepo)
    {
        $this->PositionRepo = $PositionRepo;
    }
    public function getAllData()
    {
        return $this->PositionRepo->getAlldata();
    }
    public function createData(PositionRequest $request)
    {
        return $this->PositionRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->PositionRepo->getDataById($id);
    }
    public function updateData(PositionRequest $request,  $id)
    {
        return $this->PositionRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->PositionRepo->deleteData($id);
    }
}
