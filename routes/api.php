<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\TrakingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\RequestStatusController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('users', 'index');
    Route::get('/users/{id}','show');
    Route::post('store', 'store');
    Route::put('/edit/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');


});

//get all branches without paginate
Route::get('branches/withoutPaginate', [BranchController::class , 'getBranchesWithoutPaginate']);

//get types request without paginate
Route::get('requestTypes/withoutPaginate', [RequestTypeController::class , 'getrequestTypeWithoutPaginate']);

//get all status request without paginate
Route::get('requestStatus/withoutPaginate', [RequestStatusController::class, 'getrequestStatusWithoutPaginate']);

//get all cities without paginate
Route::get('cities/withoutPaginate', [CityController::class , 'getCitiessWithoutPaginate']);

//get all categories without paginate
Route::get('categories/withoutPaginate', [CategoryController::class , 'getcategoryWithoutPaginate']);

//get all roles without paginate
Route::get('roles/withoutPaginate', [RoleController::class , 'getRoleWithoutPaginate']);


//get Count Of Request
Route::get('requests/total', [RequestController::class, 'getTotalRequests']);

//get count request type complaints
Route::get('requests/complaints/count', [RequestController::class, 'getComplaintsCount']);

//get count request  resolved status
Route::get('requests/resolved/count', [RequestController::class, 'getResolvedCount']);

/*-------------------------------------------------------------------------------------------------------------*/

//applicants
Route::apiResource('applicants', ApplicantController::class);

//categories
Route::apiResource('categories', CategoryController::class);

//categories
Route::apiResource('categories', CategoryController::class);

//Branch
Route::apiResource('branches', BranchControApplicantControllerller::class);

//RequestTypes
Route::apiResource('requestTypes', RequestTypeController::class);


//RequestStatus
Route::apiResource('requestStatus', RequestStatusController::class);

//reports
Route::apiResource('reports', ReportController::class);


//requests
Route::apiResource('requests', RequestController::class);

//trakings
Route::apiResource('trakings', TrakingController::class);

//Role
Route::apiResource('roles', RoleController::class);


Route::get('/requests/attachments/by-id/{id}', [RequestController::class, 'getAttachmentsByApplicantId']);

Route::get('requests/getRequestByReferenceCode/{reference_code}', [RequestController::class, 'getRequestByReferenceCode']);

//update status request
Route::patch('/requests/{request}/status', [RequestController::class, 'updateStatus']);


//store only request
Route::post('/requestOnly', [RequestController::class, 'storeOnly']);

//city
Route::apiResource('cities', CityController::class);


