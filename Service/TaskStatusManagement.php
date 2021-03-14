<?php

namespace Magemastery\Todo\Service;

use Magemastery\Todo\Api\TaskManagementInterface;
use Magemastery\Todo\Api\TaskRepositoryInterface;
use Magemastery\Todo\Api\TaskStatusManagementInterface;
use Magemastery\Todo\Model\Task;

class TaskStatusManagement implements TaskStatusManagementInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @var TaskManagementInterface
     */
    private $management;

    /**
     * TaskStatusManagement constructor.
     * @param TaskRepositoryInterface $taskRepository
     * @param TaskManagementInterface $taskManagement
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskManagementInterface $taskManagement
    ) {
        $this->repository = $taskRepository;
        $this->management = $taskManagement;
    }

    /**
     * @param int $taskId
     * @param string $status
     * @return bool
     */
    public function change(int $taskId, string $status): bool
    {
        if (!in_array($status, ['open', 'complete'])) {
            return false;
        }

        $task = $this->repository->get($taskId); //получить задачу
        $task->setData(Task::STATUS, $status); //засетать статус
        $this->management->save($task); //сохранить задачу

        return true;
    }
}
