<?php

declare(strict_types=1);

namespace Magemastery\Todo\Service;

use Magemastery\Todo\Api\Data\TaskInterface;
use Magemastery\Todo\Api\TaskManagementInterface;
use Magemastery\Todo\Model\ResourceModel\Task;

class TaskManagement implements TaskManagementInterface
{
    /**
     * @var Task
     */
    private $resource;

    /**
     * TaskManagement constructor.
     * @param Task $resource
     */
    public function __construct(Task $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param TaskInterface $task
     * @return bool
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(TaskInterface $task): int
    {
        $this->resource->save($task); //передаем объект задачи, сохраняем
        return $task->getTaskId(); //чтобы при создании задачи возвращать ее id и ипользовать id на фронте
    }

    /**
     * @param TaskInterface $task
     * @return bool
     * @throws \Exception
     */
    public function delete(TaskInterface $task): bool
    {
        $this->resource->delete($task);
        return true;
    }
}
