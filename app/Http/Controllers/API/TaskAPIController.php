<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TaskController
 */

class TaskAPIController extends AppBaseController
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepo)
    {
        $this->taskRepository = $taskRepo;
    }

    /**
     * @OA\Get(
     *      path="/tasks",
     *      summary="getTaskList",
     *      tags={"Task"},
     *      description="Get all Tasks",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Task")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->taskRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/tasks",
     *      summary="createTask",
     *      tags={"Task"},
     *      description="Create Task",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Task")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Task"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $task = $this->taskRepository->create($input);

        return $this->sendResponse($task->toArray(), 'Task saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/tasks/{id}",
     *      summary="getTaskItem",
     *      tags={"Task"},
     *      description="Get Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Task"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        return $this->sendResponse($task->toArray(), 'Task retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/tasks/{id}",
     *      summary="updateTask",
     *      tags={"Task"},
     *      description="Update Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Task")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Task"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task = $this->taskRepository->update($input, $id);

        return $this->sendResponse($task->toArray(), 'Task updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/tasks/{id}",
     *      summary="deleteTask",
     *      tags={"Task"},
     *      description="Delete Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Task $task */
        $task = $this->taskRepository->find($id);

        if (empty($task)) {
            return $this->sendError('Task not found');
        }

        $task->delete();

        return $this->sendSuccess('Task deleted successfully');
    }
}
