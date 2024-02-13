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

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Region\RegionController;


Route::post("/auth/login", [AuthController::class, 'login']);
Route::post("/auth/logout", [AuthController::class, 'logout']);
Route::get("/regions", [RegionController::class, 'getAll']);
Route::post("/regions", [RegionController::class, 'add']);
Route::put("/regions/{region}", [RegionController::class, 'change']);
Route::delete("/regions/{region}", [RegionController::class, 'delete']);
Route::get("/regions/{region}/organizations", [RegionController::class, 'organizations']);
Route::post("/regions/{region}/organizations", [RegionController::class, 'getOrganizations']);
Route::put("/regions/{region}/organizations/{organization}", [RegionController::class, 'changeOrganizations']);
Route::delete("/regions/{region}/organizations/{organization}", [RegionController::class, 'deleteOrganizations']);
