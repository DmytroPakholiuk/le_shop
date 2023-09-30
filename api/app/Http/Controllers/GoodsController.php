<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoodsRequest;
use App\Http\Requests\UpdateGoodsRequest;
use App\Models\FilterModels\FilterGoods;
use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterModel = new FilterGoods($request);
        return ["data" => $filterModel->search()->get()];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGoodsRequest $request)
    {
        try {
            $data = $request->validated();
            $goods = new Goods();

            // I don't trust the mass-insertion yet.
            $goods->name = $data["name"];
            $goods->description = $data["description"];
            $goods->price = $data["price"];
            $goods->available = boolval($data["available"]);
            $goods->category_id = $data["category_id"];
            $goods->author_id = Auth::id();
            $goods->save();

            return ["data" => $goods];
        } catch (\Throwable $exception) {
            echo $exception->getTraceAsString();die();
        }
    }

    /**
     * just like index, but it shows a collection of random goods
     * @return array
     */
    public function random(Request $request)
    {
        $perPage = $request->get("per_page");
        if ($perPage == null || $perPage > 200){
            $perPage = 20;
        }

        return ["data" => Goods::inRandomOrder()->limit($perPage)->get()];
    }

    /**
     * Display the specified resource.
     */
    public function show(Goods $goods)
    {
        // might later be used to show one requested resource model. Route callback might be a limited choice for this
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGoodsRequest $request)
    {
        try {
            $data = $request->validated();
            $goods = Goods::findOrFail($data["id"]);

            // I don't trust the mass-insertion yet.
            $goods->name = $data["name"];
            $goods->description = $data["description"];
            $goods->price = $data["price"];
            $goods->available = boolval($data["available"]);
            $goods->category_id = $data["category_id"];
            $goods->author_id = Auth::id();
            $goods->save();

            return ["data" => $goods];
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
            echo $exception->getTraceAsString();die();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goods $goods)
    {
        // todo: remember about actually soft-deleting model via status change
    }
}
