<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->input('name'),
            'user_id' => 1
        ]);
        return response()->json([
            'error' => false,
            'message' => 'Category Created Successfully',
            'data' => ['category' => $category]
        ], 201);
    }
}
