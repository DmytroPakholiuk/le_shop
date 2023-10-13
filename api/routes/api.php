<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodsController;
use App\Models\Category;
use App\Models\Goods;
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

Route::prefix("categories")->controller(CategoryController::class)->group(function () {
    Route::get("/", "index");
    Route::get("/{category}", function (Category $category) {
        return ["data" => $category];
    })->whereNumber("category");
});

Route::prefix("goods/{goodsId}/attributes")->controller(AttributeController::class)->group(function () {
    Route::get("/", function (Request $request, AttributeController $controller, $goodsId) {
        return $controller->indexForGoods($request, $goodsId);
    });
})->whereNumber("goodsId");

Route::prefix("goods")->controller(GoodsController::class)->group(function () {
    Route::post("/", "store")->middleware('auth:api');
    Route::put("/{id}", "update")->middleware('auth:api');
    Route::get("/", "index");
    Route::get("/{goods}", function (Goods $goods) {
        return ["data" => $goods];
    })->whereNumber("goods");
    Route::get("/random", "random");
});

