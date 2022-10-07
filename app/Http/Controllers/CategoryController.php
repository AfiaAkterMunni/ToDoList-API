<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\task;

class CategoryController extends Controller
{
    public function index()
    {
        try {

            $userId = Auth::id();
            $categories = Category::where('user_id', $userId)->get();
            return response()->json([
                'error' => false,
                'message' => 'All Category',
                'data' => ['categories' => $categories]
            ], 200);
        }
        catch (Exception $e) {
            $status = $e->getCode() > 500 ? 500 : $e->getCode();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], $status);
        }
    }

    public function select(DateRequest $request)
    {
        try {
            $categoryIds = Task::whereDate('date',$request->date)->get('category_id');
            $selectedCategories = Category::whereIn('id', $categoryIds)->get();
            return response()->json([
                'error' => false,
                'message' => 'Selected Category of '.$request->date,
                'data' => ['selectedCategories' => $selectedCategories]
            ], 200);
        }
        catch (Exception $e) {
            $status = $e->getCode() > 500 ? 500 : $e->getCode();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], $status);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try{
            $category = Category::create([
                'name' => $request->input('name'),
                'user_id' => Auth::id()
            ]);
            return response()->json([
                'error' => false,
                'message' => 'Category Created Successfully',
                'data' => ['category' => $category]
            ], 201);
        }
        catch (Exception $e) {
            $status = $e->getCode() > 500 ? 500 : $e->getCode();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], $status);
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
            $status = $e->getCode() > 500 ? 500 : $e->getCode();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], $status);
        }
    }
}
