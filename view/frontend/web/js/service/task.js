// AJAX-запрос - без перезагрузки страницы например. ОТправляется запрос на сервер.
// используем mage/storage, с помощью которого можем отправить http post/get/put/delete запросы на бэкенд
// делаем get запрос на rest/наш эндпоинт
define(['mage/storage'], function (storage) {
    'use strict';

    return {
        getList: async function () {
            return storage.get('rest/V1/customer/todo/tasks'); // этот запрос в network можно увидеть
        },

        // метод передает на бэк запрос и два аргумента (taskId, status)
        //Метод JSON.stringify() преобразует значение JavaScript в строку JSON. В нашем случае на бэк будет передаваться два аргумента taslId и status
        update: async function (taskId, status) {
            return storage.post(
                'rest/V1/customer/todo/task/update',
                JSON.stringify({
                    taskId: taskId,
                    status: status
                })
            );
        },

        // метод передает на бэк запрос и объект (task)
        delete: async function (task) {
            return storage.post(
                'rest/V1/customer/todo/task/delete',
                JSON.stringify({task: task})
            );
        },

        // метод передает на бэк запрос и объект (task)
        create: async function (task) {
            return storage.post(
                'rest/V1/customer/todo/task/create',
                JSON.stringify({task: task})
            );
        }
    };
});
