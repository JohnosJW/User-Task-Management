<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TaskController
 * @package App\Http\Controllers\Api\V1
 */
class TaskController extends Controller
{
    /** @var TaskRepositoryInterface */
    private $taskRepository;

    /**
     * TaskController constructor.
     * @param TaskRepositoryInterface $taskRepository
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        return $this->successResponse([
            'data' => $this->taskRepository->findTodayTasks($user),
        ]);
    }

    /**
     * @param Request $request
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function store(Request $request, TaskService $taskService): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'password' => '',
        ]);

        $title = $validatedData['title'];
        $description = $validatedData['description'];

        /** @var User $user */
        $user = $request->user();

        try {
            $data = $taskService->create($user, $title, $description);

            return $this->successResponse([
                'data' => $data,
            ]);
        } catch (\DomainException $e) {
            return $this->errorResponse([$e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @param string $status
     * @param Request $request
     * @param TaskService $taskService
     * @return JsonResponse
     */
    public function setStatus(int $id, string $status, Request $request, TaskService $taskService): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $data = [];

        /** @var Task $task */
        $task = $this->taskRepository->findById($id);

        if ($user->id !== $task->user_id) {
            return $this->errorResponse(['message' => 'Not correct task']);
        }

        try {
            if (in_array($status, Task::STATUS_LIST)) {
                $data = $taskService->setStatus($task, $status);
            }

            return $this->successResponse([
                'data' => $data,
            ]);
        } catch (\DomainException $e) {
            return $this->errorResponse([$e->getMessage()]);
        }
    }
}
