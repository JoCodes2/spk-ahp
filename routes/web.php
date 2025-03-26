<?php

use App\Http\Controllers\CMS\CriteriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// route api
Route::prefix('v1')->group(function () {
    // Routes criteria
    Route::prefix('criteria')->controller(CriteriaController::class)->group(function () {
        Route::get('/', 'getAllData');
    });

    // Routes criteria-values
    Route::prefix('criteria-values')->controller(CriteriaController::class)->group(function () {
        Route::get('/', 'getAllData');
        Route::post('/create', 'createData');
        Route::get('/get/{id}', 'getDataById');
        Route::post('/update/{id}', 'updateData');
        Route::delete('/delete/{id}', 'deleteData');
    });
});
