<?php

namespace Magemastery\Todo\Controller\Index;

use Magemastery\Todo\Api\TaskManagementInterface;
use Magemastery\Todo\Model\ResourceModel\Task as TaskResource;
use Magemastery\Todo\Model\Task;
use Magemastery\Todo\Model\TaskFactory;
use Magemastery\Todo\Service\TaskRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    private $taskResource;

    private $taskFactory;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    private $searchCriteriaBuilder;

    /**
     * @var TaskManagementInterface
     */
    private $taskManagement;

    // проверим, что наши модель/ресурс модель сохраняют в БД дату. $taskFactory - создает объекты класса.
    // В папке generated отрастает класс, когда контроллер дернем
    public function __construct(
        Context $context,
        TaskFactory $taskFactory,
        TaskResource $taskResource,
        TaskRepository $taskRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        TaskManagementInterface $taskManagement
    ) {
        $this->taskFactory = $taskFactory;
        $this->taskResource = $taskResource;
        $this->taskRepository = $taskRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->taskManagement = $taskManagement;
        parent::__construct($context);
    }

    public function execute() //возвращаем объект типа PAGE
    {
        // используем TaskManagement и перезаписываем задачу из бд
//        $task = $this->taskRepository->get(1);
//        $task->setData('label', 'zxc');
//        $this->taskManagement->save($task);
//        var_dump($task->getData());

        // возвращаем один объект
//        $task = $this->taskRepository->get(2);
//        var_dump($task->getData());

        // возвращаем объекты всех задач из бд
//        var_dump($this->taskRepository->getList($this->searchCriteriaBuilder->create())->getItems());

//        // тестировали модель-ресурс модель
//        $task = $this->taskFactory->create();       //taskFactory->create - создаем объект класса Task
//        $task->setData([                            // сетаем в объект дату
//            'label' => 'task1',
//            'status' => 'open',
//            'customer_id' => 1
//        ]);
//        $this->taskResource->save($task);           // используя ResourceModel сохраняем в БД дату

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
// когда контроллер будет вызван, родительский класс контроллера найдет лайаут, привязанный к этому контроллеру
// (todo_index_index - rout id = to do, index, index) и загрузит контент этого лайаута.
