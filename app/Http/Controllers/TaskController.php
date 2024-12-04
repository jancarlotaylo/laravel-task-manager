<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a list of tasks with optional filtering, sorting, and pagination.
     *
     * @param Request $request The incoming HTTP request containing query parameters for filtering, sorting, and pagination.
     * @return View The view displaying the tasks.
     */
    public function index(Request $request): View
    {
        // Used for status filter
        $taskStatuses = TaskStatus::values();

        // Get the 'sort' and 'direction' parameters from the request, with defaults
        $sort = $request->get('sort', 'id'); // Default to 'id' column if no sort is provided
        $direction = $request->get('direction', 'asc'); // Default to 'asc' direction

        // Validate the direction to ensure it's either 'asc' or 'desc'
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        // Start the query
        $query = Task::assignedToUser(); // Use the assignedToUser scope to ensure the task belongs to the authenticated user

        // Apply search by title if 'search' parameter exists
        if ($request->has('search') && $request->get('search') !== '') {
            $searchTerm = $request->get('search');
            $query->where('title', 'like', "%$searchTerm%");
        }

        // Apply filter by status if 'status' parameter exists
        if ($request->has('status') && $request->get('status') !== '' && $request->get('status') !== null) {
            $status = $request->get('status');
            $query->where('status', $status);
        }

        // Apply sorting
        $tasks = $query->orderBy($sort, $direction)
                    ->paginate($request->get('limit', 10)); // Default to 10 records per page

        return view('tasks.index', compact('tasks', 'taskStatuses'));
    }

    /**
     * Show the form to add a new task.
     *
     * @return View The view with the form to add a new task.
     */
    public function add(): View
    {
        $taskStatuses = TaskStatus::values();

        return view('tasks.add', compact('taskStatuses'));
    }

    /**
     * Store a newly created task in the database.
     *
     * @param TaskStoreRequest $request The validated request data for storing a task.
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function store(TaskStoreRequest $request): JsonResponse
    {
        try {
            // Create the task using validated data
            $task = Task::create($request->validated());

            // Return success message with task data
            return response()->json([
                'message' => 'Task added successfully!',
                'task' => $task,
            ], 201);  // HTTP 201 for resource creation
        } catch (\Exception $e) {
            // Catch any unexpected errors and return a failure response
            return response()->json([
                'message' => 'There was an error adding the task.',
                'error' => $e->getMessage(),
            ], 500);  // HTTP 500 for server error
        }
    }

    /**
     * Display a specific task.
     *
     * @param Task $task The task instance to be displayed.
     * @return View The view displaying the task details.
     */
    public function show(Task $task): View
    {
        // Use the assignedToUser scope to ensure the task belongs to the authenticated user
        $task = Task::assignedToUser()->find($task->id);

        if (! $task) {
            return view('forbidden');
        }

        return view('tasks.view', compact('task'));
    }

    /**
     * Show the form to edit an existing task.
     *
     * @param Task $task The task instance to be edited.
     * @return View The view with the form to edit the task.
     */
    public function edit(Task $task): View
    {
        // Use the assignedToUser scope to ensure the task belongs to the authenticated user
        $task = Task::assignedToUser()->find($task->id);

        if (! $task) {
            return view('forbidden');
        }

        $taskStatuses = TaskStatus::values();

        return view('tasks.edit', compact('task', 'taskStatuses'));
    }

    /**
     * Update the details of an existing task.
     *
     * @param Task $task The task instance to be updated.
     * @param TaskUpdateRequest $request The validated request data for updating the task.
     * @return JsonResponse A JSON response indicating success or failure.
     */
    public function update(Task $task, TaskUpdateRequest $request): JsonResponse
    {
        try {
            // Update the task using validated data
            $task = Task::findOrFail($task->id);
            $task->update($request->validated());

            // Return success message with task data
            return response()->json([
                'message' => 'Task updated successfully!',
                'task' => $task,
            ], 201);  // HTTP 201 for resource creation
        } catch (\Exception $e) {
            // Catch any unexpected errors and return a failure response
            return response()->json([
                'message' => 'There was an error editing the task.',
                'error' => $e->getMessage(),
            ], 500);  // HTTP 500 for server error
        }
    }
}