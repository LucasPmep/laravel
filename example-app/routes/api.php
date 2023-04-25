<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CivilityController;
use App\Http\Controllers\Api\DepartementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::apiResource('persons', PersonController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('departements', DepartementController::class);
Route::apiResource('civilities', CivilityController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});