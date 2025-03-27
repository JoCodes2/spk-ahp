<?php

namespace App\Interface;

use App\Http\Requests\ApplicantRequest;
use App\Models\Applicant;

interface ApplicantInterfaces
{
    public function getAllData();
    public function createData(ApplicantRequest $request);
    public function getDataById($id);
    public function updateData(ApplicantRequest $request,  $id);
    public function deleteData($id);
}
