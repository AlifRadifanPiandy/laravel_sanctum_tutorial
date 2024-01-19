<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;

class TasksController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve tasks from the database where the 'user_id' column matches the currently authenticated user's ID.
        $tasks = Task::where('user_id', Auth::user()->id)->get();

        // Return a new TasksResource instance, which will format the task data in a desired way.
        return TasksResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        // Validate the data received from the request.
        $validatedData = $request->validated();

        // Create a new task using the validated data.
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'priority' => $validatedData['priority']
        ]);

        // Return a new TasksResource instance, which will format the task data in a desired way.
        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        // Check if the task belongs to the currently authenticated user.
        if ($task->user_id !== Auth::user()->id) {
            return $this->error('', 'Unauthorized', 403);
        }

        // Return a new TasksResource instance, which will format the task data in a desired way.
        return new TasksResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Check if the task belongs to the currently authenticated user.
        if ($task->user_id !== Auth::user()->id) {
            return $this->error('', 'Unauthorized', 403);
        }

        // Validate the data received from the request.
        $validatedData = $request->validated();

        // Update the task using the validated data.
        $task->update($validatedData);

        // Return a new TasksResource instance, which will format the task data in a desired way.
        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // Check if the task exists.
        if (!$task) {
            return $this->error('', 'Task not found', 404);
        }

        // Check if the task belongs to the currently authenticated user.
        if ($task->user_id !== Auth::user()->id) {
            return $this->error('', 'Unauthorized', 403);
        }

        // Delete the task from the database and check if the deletion was successful.
        if (!$task->delete()) {
            return $this->error('', 'Deletion failed', 500);
        }

        // Return a success message.
        return $this->success('', 'Task deleted successfully');
    }
}
