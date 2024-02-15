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
use App\Http\Controllers\Categori\CategoriController;
use App\Http\Controllers\Consultation\ConsultationController;


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
Route::get("/regions/{region}/organizations/{organization}/consultants", [RegionController::class, 'ConsultantsOrganizations']);
Route::post("/regions/{region}/organizations/{organization}/consultants", [RegionController::class, 'AddConsultants']);
Route::put("/regions/{region}/organizations/{organization}/consultants/{consultant}", [RegionController::class, 'ChangeConsultant']);
Route::delete("/regions/{region}/organizations/{organization}/consultants/{consultant}", [RegionController::class, 'DeleteConsultant']);
Route::get("/categories", [CategoriController::class, 'getAll']);
Route::post("/categories", [CategoriController::class, 'add']);
Route::put("/categories/{category}", [CategoriController::class, 'change']);
Route::delete("/categories/{category}", [CategoriController::class, 'delete']);
Route::get("/categories/{category}/problems", [CategoriController::class, 'getProblems']);
Route::post("/categories/{category}/problems", [CategoriController::class, 'addProblems']);
Route::put("/categories/{category}/problems/{problem}", [CategoriController::class, 'changeProblems']);
Route::delete("/categories/{category}/problems/{problem}", [CategoriController::class, 'deleteProblems']);
Route::get("/consultations", [ConsultationController::class, 'getAll']);
Route::get("/consultations/{consultation}", [ConsultationController::class, 'get']);
Route::post("/consultations", [ConsultationController::class, 'add']);
Route::patch("/consultations/{consultation}", [ConsultationController::class, 'rating']);
