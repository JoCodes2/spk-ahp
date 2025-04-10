<?php

use App\Http\Controllers\CMS\ApplicantController;
use App\Http\Controllers\CMS\ApplicantScoresController;
use App\Http\Controllers\CMS\CriteriaController;
use App\Http\Controllers\CMS\CriteriaValuesController;
use App\Http\Controllers\CMS\PositionController;
use App\Http\Controllers\CMS\ResultAhpContrroller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('v1/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return view('Auth.Login');
})->name('login')->middleware('guest');


Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/', function () {
        return view('Admin.dashboard');
    });
    Route::get('/criteria', function () {
        return view('Admin.criteria');
    });
    Route::get('/kandidat', function () {
        return view('Admin.kandidat');
    });
    Route::get('/applicant-scores', function () {
        return view('Admin.applicantSocres');
    });
    Route::get('/arsip-ahp', function () {
        return view('Admin.arsip-ahp');
    });


    // route api
    Route::prefix('v1')->group(function () {
        // Routes criteria
        Route::prefix('criteria')->controller(CriteriaController::class)->group(function () {
            Route::get('/', 'getAllData');
        });

        // Routes criteria-values
        Route::prefix('criteria-values')->controller(CriteriaValuesController::class)->group(function () {
            Route::get('/', 'getAllData');
            Route::post('/create', 'createData');
            Route::get('/get/{id}', 'getDataById');
            Route::post('/update/{id}', 'updateData');
            Route::delete('/delete/{id}', 'deleteData');
        });

        // Routes criteria-values
        Route::prefix('position')->controller(PositionController::class)->group(function () {
            Route::get('/', 'getAllData');
            Route::post('/create', 'createData');
            Route::get('/get/{id}', 'getDataById');
            Route::post('/update/{id}', 'updateData');
            Route::delete('/delete/{id}', 'deleteData');
        });

        Route::prefix('applicant')->controller(ApplicantController::class)->group(function () {
            Route::get('/', 'getAllData');
            Route::post('/create', 'createData');
            Route::get('/get/{id}', 'getDataById');
            Route::post('/update/{id}', 'updateData');
            Route::delete('/delete/{id}', 'deleteData');
        });
        // route applicant-scores
        Route::prefix('applicants-scores')->controller(ApplicantScoresController::class)->group(function () {
            Route::get('/', 'getAllData');
            Route::post('/create', 'createData');
            Route::delete('/delete', 'deleteAll');
        });
        // route result ahp
        Route::prefix('ahp')->controller(ResultAhpContrroller::class)->group(function () {
            Route::get('/', 'getAllData');
            Route::post('/create', 'createData');
            Route::delete('/delete', 'arsipData');
        });
    });

    Route::post('v1/logout', [AuthController::class, 'logout']);
});
