<?php

namespace App\Http\Controllers\API;

use App\DTOs\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Task management API"
 * )
 */
class TaskAPIController extends Controller
{
    public function __construct(
        private TaskService $taskService,
        private TaskRepository $taskRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="List tasks",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="status", in="query", @OA\Schema(type="string", enum={"todo", "done"})),
     *     @OA\Parameter(name="priority", in="query", @OA\Schema(type="integer", minimum=1, maximum=5)),
     *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort", in="query", @OA\Schema(type="string", example="priority:desc,created_at:asc")),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task"))
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = $this->taskRepository->query();

        $query = $this->taskRepository->applyFilters($query, [
            'status' => $request->status,
            'priority' => $request->priority,
            'search' => $request->search,
        ]);

        $query = $this->taskRepository->applySorting($query, $request->sort);

        return response()->json(TaskResource::collection($query->paginate()));
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create task",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=201, description="Task created", @OA\JsonContent(ref="#/components/schemas/Task"))
     * )
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        $task = $this->taskService->create(TaskDTO::fromArray($request->validated()));
        return response()->json(new TaskResource($task), 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update task",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(response=200, description="Task updated", @OA\JsonContent(ref="#/components/schemas/Task"))
     * )
     */
    public function update(UpdateTaskAPIRequest $request, int $id): JsonResponse
    {
        $task = $this->taskService->update($id, TaskDTO::fromArray($request->validated()));
        return response()->json(new TaskResource($task));
    }

    /**
     * @OA\Patch(
     *     path="/api/tasks/{id}/complete",
     *     summary="Mark task as completed",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Task completed", @OA\JsonContent(ref="#/components/schemas/Task"))
     * )
     */
    public function complete(int $id): JsonResponse
    {
        $task = $this->taskService->markAsCompleted($id);
        return response()->json(new TaskResource($task));
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete task",
     *     tags={"Tasks"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Task deleted")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->taskService->delete($id);
        return response()->json(null, 204);
    }
}