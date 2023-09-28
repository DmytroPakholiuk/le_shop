<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\GoodsImageController;
use App\Models\Category;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("category")->controller(CategoryController::class)->group(function () {
    Route::get("/", "index");
    Route::get("/{category}", function (Category $category) {
        return ["data" => $category];
    })->whereNumber("category");
});

Route::prefix("goods")->controller(GoodsController::class)->group(function () {
    Route::get("/", "index");
    Route::get("/{id}", "show");
    Route::get("/random", "random");
});

//Route::prefix("goods-images")->controller(GoodsImageController::class)->group(function () {
//    Route::get();
//});


