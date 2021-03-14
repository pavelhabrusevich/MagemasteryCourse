<?php

namespace Magemastery\Todo\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

// ресурс модель для того, чтобы инициализировать таблицу. Для загрузки данных из БД. sql запросы. Каждая модель должна иметь модель ресурсов, поскольку все методы модели ресурсов ожидают модель в качестве своего первого параметра.
// ресурс-модель как клас обеспечивает возможность выполнения CRUD операция.
// в методе указываем имя таблицы и колонку
class Task extends AbstractDb
{
    protected function _construct()
    {
        $this->_init("magemastery_todo_task", "task_id");
    }
}
