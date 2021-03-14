<?php

namespace Magemastery\Todo\Model\ResourceModel\Task;

use Magemastery\Todo\Api\Data\TaskSearchResultInterface;
use Magemastery\Todo\Model\ResourceModel\Task as TaskResource;
use Magemastery\Todo\Model\Task;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

// Коллекции используются, когда мы хотим получить несколько строк из нашей таблицы. Получить несколько строк из таблицы Объедините таблицы с нашей основной таблицей Выберите определенные столбцы Примените предложение WHERE к нашему запросу Используйте в нашем запросе GROUP BY или ORDER BY
// когда загружается коллеция записей, коллекция Collection проходится по всем данным и создает объекты типа Task (модули)
// имплементируем TaskSearchResultInterface для того, чтобы из TaskRepository->getList вернуть объект типа TaskSearchResultInterface
class Collection extends AbstractCollection implements TaskSearchResultInterface
{
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    protected function _construct()
    {
        $this->_init(Task::class, TaskResource::class);
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria() //будет возвращать объект с переменной $searchCriteria
    {
        return $this->searchCriteria;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return Collection
     * @SuppressWarnings (PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null) //сетать этот объект
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount() // чтобы TaskSearchResultInt мог вернуть кол-во элементов массива
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings (PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this
     * @throws \Exception
     */
    public function setItems(array $items = null)
    {
        if (!$items) {
            return $this;
        }
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }
}
