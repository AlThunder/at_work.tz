<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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


$groupData = [
    'namespace' => '\App\Http\Controllers\Api',
    'middleware' => 'api',
];
Route::group($groupData, function () {
    // Users
    Route::apiResources([
        'users'=> UserController::class,
    ]);
});

Route::group($groupData, function () {
    // Companies
    Route::apiResources([
        'companies'=> CompanyController::class,
    ]);
});

Route::group($groupData, function () {
    // Comments
    Route::apiResources([
        'comments'=> CommentController::class,
    ]);
});

Route::get('companies/comments/{company}', [\App\Http\Controllers\Api\CompanyController::class, 'getComments']);
Route::get('companies/rate/{company}', [\App\Http\Controllers\Api\CompanyController::class, 'getRate']);
Route::get('companies/top/{limit}', [\App\Http\Controllers\Api\CompanyController::class, 'getTopRated']);
