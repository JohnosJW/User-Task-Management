<?php


namespace App\Repositories;


use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;

/**
 * Class TaskRepository
 * @package App\Repositories
 */
class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return Task::find($id);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function findTodayTasks(User $user)
    {
        return Task::where([
                'status' => Task::STATUS_ACTIVE,
                'date' => (new \DateTime())->format('Y-m-d'),
                'user_id' => $user->id
            ])
            ->orderBy('id', 'ASC')
            ->get();
    }
}
