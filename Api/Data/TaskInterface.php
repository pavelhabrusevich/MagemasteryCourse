<?php
declare(strict_types=1);

namespace Magemastery\Todo\Api\Data;

// предоставляет данные по одной конкретной задаче

/**
 * @api
 */
interface TaskInterface
{
    // важно указать тип возвращаемых днных в методах.
    // методы добавляем как я понимаю, потому что у нас реализован сервис API CustomerTaskList
    // методы реализуем в модели Task
    /**
     * @return int
     */
    public function getTaskId(): int;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param $taskId
     * @return void
     */
    public function setTaskId(int $taskId);

    /**
     * @param $status
     * @return void
     */
    public function setStatus(string $status);

    /**
     * @param $label
     * @return void
     */
    public function setLabel(string $label);
}
