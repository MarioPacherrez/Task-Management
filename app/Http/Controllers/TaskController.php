<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $tasks = Task::where('user_id', $user->id)->paginate(10);
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada.'], 404);
        }

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada.'], 404);
        }

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $task = Task::where('id', $id)->where('user_id', $user->id)->first();

        if (!$task) {
            return response()->json(['error' => 'Tarea no encontrada.'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente.']);
    }
}
