<?php

namespace App\Http\Controllers\CMS;

use App\Http\Requests\ApplicantRequest;
use App\Repositories\applicantRepositories;
use Illuminate\Http\Request;

class ApplicantController
{
    protected $ApplicantRepo;
    public function __construct(applicantRepositories $ApplicantRepo)
    {
        $this->ApplicantRepo = $ApplicantRepo;
    }
    public function getAllData()
    {
        return $this->ApplicantRepo->getAlldata();
    }
    public function createData(ApplicantRequest $request)
    {
        return $this->ApplicantRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->ApplicantRepo->getDataById($id);
    }
    public function updateData(ApplicantRequest $request,  $id)
    {
        return $this->ApplicantRepo->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->ApplicantRepo->deleteData($id);
    }
}
