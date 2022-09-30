<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UpdateTaskRequest;
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
