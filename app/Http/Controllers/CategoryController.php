<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request)
    {
        try{
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
        catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                $category->delete();
            } else {
                throw new Exception("Not Found!", 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Category Deleted Successfully',
                'data' => ['category' => $category]
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
