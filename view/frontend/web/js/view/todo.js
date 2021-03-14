define(
    [
    'uiComponent',
    'jquery', // библиотеку jquery добавялем в зависимость для обработки ивентов. добавляется $ в function (Component, $)
    'Magento_Ui/js/modal/confirm', // добавляем в зависимость магенто ui модуль, чтобы модальное окно заюзать
    'Magemastery_Todo/js/service/task', // добавляем в зависимость созданный нами сервис, который загружает задачи из бэка
    'Magemastery_Todo/js/model/loader' // добавляем в зависимость созданный нами спинер
    ],
    function (Component, $, modal, taskService, loader) {
    'use strict';
    //вот прям из js наши tasks будут залетать в todohtml и уже там обрабатываться repeat="foreach:
    return Component.extend({
        defaults: {
            newTaskLabel: '',
            buttonSelector: '#add-new-task-button',
            tasks: []
        },
        // вешаем обзервер на массив tasks
        // добавляем в обзервер newTaskLabel - в поля добавления новой задачи (to do.html).
        // Эта переменная становится обзервабл, поэтому ее можно юзать в нашей вьюшке (to do.html).
        initObservable: function () {
            this._super().observe(['tasks', 'newTaskLabel']);

            var self = this;
            taskService.getList().then (function (tasks) { // метод getList загрузит задачи с бэка, и далее их в функцию передаст
                self.tasks(tasks); // обращаемся к массиву tasks и присваиваем значение полученное от getList. Т.е. загружаем задачи в наш компонент
                return tasks; // возвращаем задачи чтобы дальше могли по цепочке промис использовать (вот тут я не понял, и без этого говна рабоает)
            });

            return this;
        },
        //переключение статуса в кружочке
        switchStatus: function (data, event) {
            //taskId - определяем id задачи по ивенту (которую кликнули в to do.html click: switchStatus)
            const taskId = $(event.target).data('id');
            //перебираем все задачи и находим ту, которую кликнули. Меняем ее статус. И все задачи возвращаем обратно в task
            var items = this.tasks().map(function (task) {
                if (task.task_id === taskId) {
                    task.status = task.status === 'open' ? 'complete' : 'open';
                    taskService.update(taskId, task.status); // отправляем на бэк новый статус задачи
                }

                return task;
            });
            //вот тут мутновато. но типо так как на наш массив tasks повесили observe, то он становится функцией tasks().
            // И в него передаем пересобранные items. Скобочки это похоже знак, что это функция
            this.tasks(items);
        },

        // проходим по массиву tasks. Если id не свпадает с тем, который передали как аргумент, то пихаем задачу в собирающмй массив
        //далее возвращаем пересобранный массив без удаленной задачи
        deleteTask: function (taskId) {
            var self = this; // как я думаю: вот эта локальная переменная self, чтобы достучаться в self.tasks. Потому что фложенность есть (функция в функции)
            modal({
                content: 'Are you sure you want to delete the message?',
                actions: {
                    confirm: function () {

                        var tasks = [];

                        taskService.delete(self.tasks().find(function (task) { // в функцию delete передаем задачу, которую находим функцией find. Find возаращет задачу, у котрой id=taskId удаляемой задачи
                            if (task.task_id === taskId) {
                                return task;
                            }
                        }));

                        if (self.tasks().length === 1){
                            self.tasks(tasks);
                            return;
                        }

                        self.tasks().forEach(function (task) {
                            if (task.task_id !== taskId){
                                tasks.push(task);
                            }
                        });

                        self.tasks(tasks);
                    }
                }
            });
        },

        // // функция добавляет из поля ввода новой задачи переменную newTaskLabel в общий список задач
        // // к newTaskLabel мы обращаемся как к функции, а имеено скобкипосле нее "()", потому что она обзервабл
        // // без скобок при добавлении нового значения предыдущие перезатираются
        // addTask: function () {
        //     this.tasks.push({
        //         id: Math.floor(Math.random() * 100),
        //         label: this.newTaskLabel(),
        //         status: false});
        //     // обнуляем newTaskLabel(), потому что уже перенесли его значение в общий список задач
        //     this.newTaskLabel('');
        // },

        // реализуем addTask уже с привязкой к бэку
        addTask: function () {
            const self = this;

            var task = {                        //создаем новый объект, который будет содеражть..
                label: this.newTaskLabel(),     // текст из поля добавления новой задачи
                status: 'open'                  // статус
            };

            loader.startLoader();

            taskService.create(task)            // вызываем созданный метод создания задачи, передаем туда созданный объект (лэйбл и статус)
                .then(function (taskId) {       // т.к. taskService.create также вернет нам id созданной задачи (это промис), то мы воспользуемся then функцией, который дождется taskId
                    task.task_id = taskId       // присваиваем нашему объекту task значение, которое вернулось с бэка
                    self.tasks.push(task)       // пушим нашу обновленную задачу в список всех задач
                    self.newTaskLabel('')       // обнуляем форму
                })

            .finally(function () {
                loader.stopLoader();
            });
        },

        // возможность добавлять задачу при нажатии Enter. По событию (нажатие Enter) мы кликаем селктор buttonSelector
        checkKey: function (data, event) {
            if (event.keyCode === 13) {
                event.preventDefault(); // эта штука хз зачем, без нее тоже рабоает. При нажатии кнопки Enter эта штука предотвращает дальнеюшую обработку события
                $(this.buttonSelector).click();
            }
        }
    });
});
