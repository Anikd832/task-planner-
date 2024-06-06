<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('validate-token', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'validateToken'])
        ->name('validate.token');
    Route::get('/user', [\App\Http\Controllers\API\UserController::class, 'authUser']);
    Route::apiResource('subjects', '\App\Http\Controllers\API\SubjectController');
    Route::apiResource('users', '\App\Http\Controllers\API\UserController');
    Route::apiResource('routines', '\App\Http\Controllers\API\RoutineController');
    Route::get('routines/get/subject-teacher-day', [\App\Http\Controllers\API\RoutineController::class,'getSubjectTeacherDay']);
});
