<?php

namespace App\Services;

use App\Models\Task\Task;

class TaskService
{
    /**
     * Create new Task and assign Employees.
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        $task = Task::create($data);

        if (isset($data['employees'])) {
            $task->employees()->sync(array_column($data['employees'], 'id'));
        }

        return $task;
    }

    /**
     * Update exist task by id and update Employees.
     * @param int $id
     * @param array $data
     * @return Task
     */
    public function update(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->fill($data)->save();

        if (isset($data['employees'])) {
            $task->employees()->sync(array_column($data['employees'], 'id'));
        }

        return $task;
    }
}
