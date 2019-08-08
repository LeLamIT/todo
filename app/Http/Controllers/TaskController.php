<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TaskController extends Controller
{
    public function index(){
        return $task = Task::all();
    }

    public function show($id){
        return Task::find($id);
    }

    public function store(Request $request){
        Task::create($request->all());
        return response()->json(['message' => 'Success!']);
    }

    public function update(Request $request, $id){
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return $task;
    }

    public function delete($id){
        $task = Task::findOrFail($id);
        $task->delete();
        return 204;
    }
}
