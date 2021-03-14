<?php

declare(strict_types=1);

namespace Magemastery\Todo\Service;

use Magemastery\Todo\Api\CustomerTaskListInterface;
use Magemastery\Todo\Api\Data\TaskInterface;
use Magemastery\Todo\Api\TaskRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CustomerTaskList implements CustomerTaskListInterface
{
    /**
     * @var TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->taskRepository = $taskRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return TaskInterface[]
     */
    public function getList() //по сути  этот метод возвращает то же, что мы накидали в контроллере. Только при API запросе
        // этот метод возвращает тип TaskInterface, и важно для web api знать точные метода/типы данных, которые должны возвращаться из интерйеса. Поэтому в интерфесе TaskInterface добавляем три метода, а далее их реализуем в модели
    {
        return $this->taskRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();
    }
}
