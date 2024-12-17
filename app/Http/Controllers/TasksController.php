<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Repositories\TaskRepository;

class TasksController extends Controller
{
    private $taskRepository;

    public function __construct()
    {
        parent::__construct();
        $this->taskRepository = app(TaskRepository::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = $this->taskRepository->getAllWithPaginate(10);
        return response()->json($records);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTasksRequest $request)
    {
        $record = $this->user->tasks()->create($request->validated());
        return response()->json($record);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $record = $this->taskRepository->getEditOrFail($id);
        return response()->json($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTasksRequest $request, $id)
    {
        $record = $this->taskRepository->update($id, $request->validated());
        return response()->json($record);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->taskRepository->delete($id);
        return response()->json(['success' => 'Deleted successfully!']);
    }
}
