<?php

namespace App\Http\Controllers\CMS;

use App\Repositories\ResultAhpRepositories;
use Illuminate\Http\Request;

class ResultAhpContrroller
{
    protected $resultAhp;
    public function __construct(ResultAhpRepositories $resultAhp)
    {
        $this->resultAhp = $resultAhp;
    }
    public function getAllData()
    {
        return $this->resultAhp->getAllData();
    }
    public function createData(Request $request)
    {
        return $this->resultAhp->createData($request);
    }
}
