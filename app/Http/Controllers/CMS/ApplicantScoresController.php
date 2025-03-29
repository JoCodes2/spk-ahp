<?php

namespace App\Http\Controllers\CMS;

use App\Repositories\ApplicantScoresRepositories;
use Illuminate\Http\Request;

class ApplicantScoresController
{
    protected $appRepo;
    public function __construct(ApplicantScoresRepositories $appRepo)
    {
        $this->appRepo = $appRepo;
    }
    public function getAllData()
    {
        return $this->appRepo->getAllData();
    }
    public function createData(Request $request)
    {
        return $this->appRepo->createData($request);
    }
    public function deleteAll()
    {
        return $this->appRepo->deleteAll();
    }
}
