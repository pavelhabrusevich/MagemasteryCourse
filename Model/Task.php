<?php

declare(strict_types=1);

namespace Magemastery\Todo\Model;

use Magemastery\Todo\Api\Data\TaskInterface; //имплементируем интерфейс для того, чтобы объект модели можно было передать в сервис TaskManagement
use Magemastery\Todo\Model\ResourceModel\Task as TaskResource;
use Magento\Framework\Model\AbstractModel;

// в модели инициализируется и добавляется связь с ResourceModel
// то есть предполагается, что через модель мы сможем вызвать методы из ResourceModel (загрузить, сохранить или удалить запись)
// общая логика запросов (?)
class Task extends AbstractModel implements TaskInterface
{

    const TASK_ID = 'task_id';
    const LABEL = 'label';
    const STATUS = 'status';

    protected function _construct()
    {
        $this->_init(TaskResource::class);
    }

    /**
     * @return int
     */
    public function getTaskId(): int
    {
        return (int) $this->getData(self::TASK_ID);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @param $taskId
     * @return void
     */
    public function setTaskId(int $taskId)
    {
        $this->setData(self::TASK_ID, $taskId);
    }

    /**
     * @param $status
     * @return void
     */
    public function setStatus(string $status)
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * @param $label
     * @return void
     */
    public function setLabel(string $label)
    {
        $this->setData(self::LABEL, $label);
    }
}
