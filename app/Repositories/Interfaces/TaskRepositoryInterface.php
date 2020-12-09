<?php


namespace App\Repositories\Interfaces;


use App\Models\User;

/**
 * Interface TaskRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface TaskRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param User $user
     * @return mixed
     */
    public function findTodayTasks(User $user);
}
