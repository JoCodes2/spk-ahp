<?php

namespace App\Interface;

use Illuminate\Http\Request;

interface ResultAhpIterfaces
{
    public function getAllData();
    public function createData(Request $request);
    public function arsipData();
}
