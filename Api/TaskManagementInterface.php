<?php

namespace Magemastery\Todo\Api;

use Magemastery\Todo\Api\Data\TaskInterface;

/**
 * @api
 */
interface TaskManagementInterface
{
    // передаем в аргумент объект модели Task, чтобы ее и сохранить. Для этого в модели Task еще имплементируем интерфейс TaskInterface
    /**
     * @param TaskInterface $task
     * @return int
     */
    public function save(TaskInterface $task): int;

    // аналогично

    /**
     * @param TaskInterface $task
     * @return mixed
     */
    public function delete(TaskInterface $task): bool;
}
