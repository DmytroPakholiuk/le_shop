<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FilterModels\FilterCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterModel = new FilterCategory($request);
        return ["data" => $filterModel->search()->get()];
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return ["data" => $category];
    }
}
