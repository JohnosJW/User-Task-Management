<?php


namespace App\Services;


use App\Models\Task;
use App\Models\User;

/**
 * Class TaskService
 * @package App\Services
 */
class TaskService
{
    /**
     * @param User $user
     * @param string $title
     * @param string $description
     * @return Task
     */
    public function create(User $user, string $title, string $description): Task
    {
        $task = new Task();
        $task->user_id = $user->id;
        $task->title = $title;
        $task->description = $description;
        $task->save();

        return $task;
    }

    /**
     * @param Task $task
     * @param string $status
     * @return Task
     */
    public function setStatus(Task $task, string $status): Task
    {
        $task->status = $status;
        $task->save();

        return $task;
    }
}
