<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{
    public function store(Request $request)
  {
    try {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo = new Todo();
        $todo->title = $request->title;
        $todo->description = $request->title;
        $todo->save();

        return response()->json([
            'status' => true,
            'message' => 'Task added successfully.'
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while adding the task.',
        ], 500); 
    }
 }

  public function getTasksDetails()
    {
        try {
            $tasks = Todo::all();
            $count = $tasks->count();
            
            return response()->json([
                'status' => true,
                'message' => 'Tasks details fetched successfully.',
                'data' => $tasks,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching task details.'
            ], 500);
        }
    }

    public function deleteTask($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();
            
            return response()->json(['status' => true, 'message' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete task.'], 500);
        }
}

    public function deleteAllTasks()
    {
        try {
            Todo::truncate();
            
            return response()->json([
                'status' => true,
                'message' => 'All tasks deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete all tasks.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);

            $todo = Todo::findOrFail($id);
            $todo->title = $request->title;
            $todo->save();

            return response()->json([
                'status' => true,
                'message' => 'Task updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update task.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}