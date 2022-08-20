Схема классов

1) Customers {
    Представляет сущность "Заказчик"
    id:
    Personal {
        Contacts {
            контакты заказчика
            email:
        }

        Password {
            работа с паролем и хэшем
        }

        Name {
            last: ,
            first: 
        }

        Avatar {
            name:
            url:
        }

        date_add: //дата регистрации на сайте
    }

    Задачи заказчика
    tascks: [
        task(1) {
            id:
            customerId:
            executorId:
            categoryId:
            AdressTask extends Adress {
                latitude:
                longitude:
                city:
            }
            Description {
                name:
                essence:
                details:
            }

            budget:

            Файлы задания
            files: [
                files(1) {
                    id:
                    name:
                },
                ...
                files(n) {}
            ]
        },
        ...
        task(n) {}
    ]

    Отзывы заказчика
    reviews: [
        review(1) {},
        ...
        review(n) {}
    ]

    Создание заказа;
    Отмена заказа;
    Выбор исполнителя;
    Присвоение заказу статуса "Выполнено";
    Добавление отзыва об исполнителе;
    Установка (изменение) адреса задания;
    Изменение своих персональных данных с помощью AccountSettings {};
    Изменение пароля с помощью Security {}.
}

2) Executors {
    Представляет сущность "Исполнитель"
    id:
    ExecutorPersonal extends Personal {
        В дополнение к Personal
        
        birthday:

        ExecutorContacts extends Contacts {
        email:
        phone:
        telegram:
        }

        СountTasks {
            количество заказов исполнителя
            all:
            failed:
        }

        Rating {
            Рейтинг исполнителя
            сумма всех оценок из отзывов / (кол-во отзывов + счетчик проваленных заданий).

        }

        Adress {
            city:
        }

        status:
        Categories {

        }
    }
    
    Password {
        работа с паролем и хэшем
    }

    Задачи исполнителя
    tascks: [
        task(1) {},
        ...
        task(n) {}
    ]

    Отзывы об испонителе
    reviews: [
        review(1) {},
        ...
        review(n) {}
    ]
    Методы:
    Отклика на задание
    Отказа от задания
    Изменение своих:
    - статуса;
    - персональных данных с помощью AccountSettings {};
    - пароля с помощью Security {}.
}

3) MyTasks {
    Представляет сущность "Фильтр заказов" заказчика или исполнителя
    Categories {

    }
    Метод установки фильтров:
    Заказчика: "Новые", "В процессе", "Закрытые"

    ExecutorTasks extends MyTasks {
        distantWork: // Удалённая работа
        noResponse: //Без откликов
        Метод установки фильтров будет переопределён:
        Исполнителя:"В процессе", "Просрочено", "Закрытые"
    }
}

4) RegistrationForms {
    Представляет сущность "Форма регистрации на сайте"
}
    4.1) CustomerRegistrationForms extends RegistrationForms {
        получение регистрационных данных;
        валидация с помощью валидаторов;
        внесение в БД;
    }

    4.2) ExecutorRegistrationForms extends RegistrationForms {
        получение регистрационных данных;
        валидация с помощью валидаторов;
        внесение в БД;
    }

5) AccountSettings {
    получение и сохранение новых данных аккаунта
}

6) FormValidator {
    Валидация форм регистрации
}

7) TaskFormValidator {
    Валидация формы нового задания
}

8) Security {
    Смена пароля;
    Отключение показ своих контактных данных для всех, кроме заказчика.
}
