<?php
declare(strict_types=1);

namespace Magemastery\Todo\Api\Data;

// создаем этот интерфейс для интерфейса TaskInterface
// а вообще этот интерфейс и TaskInterface нужны для дальнейшей реализации сервиса TaskRepository
use Magento\Framework\Api\SearchResultsInterface;

/**
 * @api
 */
interface TaskSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return TaskInterface[]
     */
    public function getItems();

    /**
     * @param TaskInterface[] $items
     * @return SearchResultsInterface
     */
    public function setItems(array $items);
}
