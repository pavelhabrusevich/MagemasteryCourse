<?php

namespace Magemastery\Todo\Service;

use Magemastery\Todo\Api\Data\TaskInterface;
use Magemastery\Todo\Api\Data\TaskSearchResultInterface;
use Magemastery\Todo\Api\Data\TaskSearchResultInterfaceFactory;
use Magemastery\Todo\Api\TaskRepositoryInterface;
use Magemastery\Todo\Model\ResourceModel\Task;
use Magemastery\Todo\Model\TaskFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @var Task
     */
    private $resource;

    /**
     * @var TaskFactory
     */
    private $taskFactory;

    /**
     * @var TaskSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * TaskRepository constructor.
     * @param Task $resource
     * @param TaskFactory $taskFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param TaskSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        Task $resource,
        TaskFactory $taskFactory,
        CollectionProcessorInterface $collectionProcessor,
        TaskSearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->resource = $resource;
        $this->taskFactory = $taskFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultFactory;
    }

    // метод возвращает все задачи. И тут похоже не создаем обект модели Task
    public function getList(SearchCriteriaInterface $searchCriteria): TaskSearchResultInterface //возвращает объект типа TaskSearchResultInterface. найденный список задач
    {
        $searchResult = $this->searchResultsFactory->create(); //создаем пустой объект. objectManager магенты посмотрит в di и создаст обект соответсвующено класаа интерфейса TaskSearchResultInterface
        $searchResult->setSearchCriteria($searchCriteria); // в объект сетаем критерии поиска (?)

        $this->collectionProcessor->process($searchCriteria, $searchResult); // готовый результат пропускаем через collectioProcessor, который проходится по всем зарегистрированным классам и вызовет обработку для нашей коллекции, которая находится в Model/ResourceModel/Task. пропускает через фильтра/сортировки и прочее и вернет в $searchResult

        return $searchResult; //результат возвращается типа TaskSearchResultInterface, и из этого интерфеса мы может вызвать метод getItems
    }

    // метод возвращает задачу нужного id
    public function get(int $taskId): TaskInterface
    {
        $object = $this->taskFactory->create(); //создаем пустой объект класа Task (модель)
        $this->resource->load($object, $taskId); //используя ресурс модель загружаем в пустой объект данные задачи по указанному праймари клюсу
        return $object; // возвращаем готовый обект
    }
}
