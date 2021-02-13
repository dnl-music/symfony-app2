1. В корневом каталоге выполнить
  $ docker-compose up -d
2. Запустить терминал контейнера с php
  $ docker exec -it symfony-app2_php_1 bash
   Далее, выполнить миграции:
   # php bin/console doctrine:migrations:migrate
   
3. На хосте добавить имя сервиса в hosts:
   $ echo "127.0.0.1  symfony-app" >> hosts
4. апи должно быть доступно по адресу symfony-app:8080

Описание АПИ:
Список новостей
GET: /api/articles
Пример:
GET: /api/articles?year=2020&month=2&page=1&tags[]=%23second_tag