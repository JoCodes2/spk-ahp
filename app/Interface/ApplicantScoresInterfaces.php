<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface ApplicantScoresInterfaces
{
    public function getAllData();
    public function createData(Request $request);
    public function deleteAll();
}
