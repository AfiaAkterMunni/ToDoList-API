<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(DateRequest $request)
    {
        try {

            $userId = Auth::id();
            $tasks = Category::with(['tasks' => function($query) use($request,$userId){
                                $query->where('date', $request->date)
                                    ->where('user_id', $userId);
                            }])
                            ->get();
            // $tasks = Task::whereDate('date', $request->date)
            //             ->where('user_id', $userId)
            //             ->groupBy('user_id')
            //             ->get();
            // dd($tasks);
            // $categories = Category::where('user_id', $userId)->get();
            return response()->json([
                'error' => false,
                'message' => 'All Task Of '.$request->date,
                'data' => ['categories' => $tasks]
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
    public function store(StoreTaskRequest $request)
    {
        try{
            $task = Task::create([
                'name' => $request->input('name'),
                'user_id' => Auth::id(),
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

    public function update(UpdateTaskRequest $request, $id)
    {
        try{
            $task = Task::find($id);
            if ($task) {
                $task->update([
                    'name' => $request->input('name'),
                    'category_id' => $request->input('category_id'),
                    'date' => $request->input('date')
                ]);
            }
            else {
                throw new Exception("Not Found!", 404);
            }
            return response()->json([
                'error' => false,
                'message' => 'Task Updated Successfully'
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

    public function statusUpdate(UpdateStatusRequest $request, $id)
    {
        try{
            $task = Task::find($id);
            if ($task) {
                $task->update([
                    'status' => $request->input('status')
                ]);
            }
            else {
                throw new Exception("Not Found!", 404);
            }
            return response()->json([
                'error' => false,
                'message' => 'Task Status Updated Successfully'
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

    public function delete($id)
    {
        try {
            $task = Task::find($id);

            if ($task) {
                $task->delete();
            } else {
                throw new Exception("Not Found!", 404);
            }

            return response()->json([
                'error' => false,
                'message' => 'Task Deleted Successfully',
                'data' => ['task' => $task]
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
