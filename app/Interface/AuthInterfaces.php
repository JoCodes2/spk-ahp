<?php

namespace App\Interface;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

interface  AuthInterfaces
{
    public function login(AuthRequest $request);
    public function logout(Request $request);
}
