<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request)
    {
        try{
            $task = Task::create([
                'name' => $request->input('name'),
                'user_id' => 1,
                'category_id' => $request->input('category_id'),
                'date' => $request->input('date'),
                'status' => false
            ]);
            return response()->json([
                'error' => false,
                'message' => 'Task Created Successfully',
                'data' => ['task' => $task]
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
}
