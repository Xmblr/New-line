### Установка
=======================================

:one: Скачайте архив

:two: Распакуйте

:three: Откройте консоль из папки распакованного архива 

:four: Введите команду  ```composer update``` или ```composer install```

:five: Во время установки введите параметры вашей базы данных

:six: После установки введите  ```php app/console assets:install web --symlink``` 

:seven: Создайте базу данных, если она еще не была создана ранее ```php app/console doctrine:database:create``` 

:eight: Обновите схему  ```php app/console doctrine:schema:update --force``` 

:nine: Загрузите фикстуры  ```php app/console doctrine:fixtures:load``` ,  на вопрос продолжить ли выполнение команды ответить: ```yes```

:one::zero: Запустите сервер командой  ```php app/console server:run```

:one::one: Перейдите по адресу http://localhost:8000/

------------------------------------------------------------------------------------------------------------------

Учтите, чтобы команда ```composer install``` запустилась, необходим установленный [composer](https://getcomposer.org/download/).
