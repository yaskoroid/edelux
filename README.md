Необходимо сделать REST API сервер на базе фреймворка Symfony 4.* который 
обеспечит простой CRUD с базой данных Clickhouse 
(https://clickhouse.yandex/docs/ru/ заменено автором на PostgreSQL 
(https://elephantsql.com)). 

Постройте 1 роут с 1-м методом CREATE
/item
этот роут должен обеспечивать создание entity внутри базы clickhouse
Постройте 1 роут с 3-мя методами PUT, GET, DELETE
/item/{stringAlias}
этот роут должен обеспечивать обновление, чтение и удаление соответсвующего 
алиасу {stringAlias} entity внутри базы clickhouse(PostgreSQL)

модель данных:
'id' - integer,
'dateTime' - timestamp,
'message' - string, max length 1024 bytes,
'owner' - enum, possible values ['admin', 'user', 'guest'],
'version' - integer

Предусмотрите пожалуйста создание таблицы в которой будут хранится 
описаные entity выше. Название таблицы - testCase. Создание таблицы должно 
срабатывать автоматом если таковая отсутствует.

Срок выполнения - 1 неделя, если справитесь быстрее, присылайте раньше.


------Ответ------

- Должен быть правильно настроен апач:
https://symfony.com/doc/current/setup/web_server_configuration.html
- Должен быть установлен драйвер PHP pgsql;
- Нужно выполнить в консоли sudo bin/console doctrine:schema:create для 
создания таблицы в БД (на данный момент она уже существует)
- В качестве {stringAlias} используется id элемента
- Реальное название таблицы в БД - testcase вместо testCase
- В данном API не продуманы такие вещи как кроссдоменные запросы, то есть
подразумевается, что отправляются или с тогоже домена браузером или с сервера
- OAuth тоже нет
- Задание "Постройте 1 роут с 1-м методом CREATE" самовольно переделал на
"Постройте 1 роут с 1-м методом POST", если смысл задачи заключался именно в 
пользовательском методе CREATE, то переделаю задачу, а так считаю это 
опечаткой, а спрашивать уже поздно, ночь.
P.S. Если я что-то сделал не то или не так понял, пишите, - исправлю.

Примеры запросов:
Create:
sudo curl -X POST -H "Content-Type: application/json" -d '{"dateTime":"2009-09-04 20:05:06","message":"Skoroid fifth item","owner":"user","version":"56"}' "http://edelux.com/api/item"

Get:
sudo url -X GET -H "Content-Type: application/json" "http://edelux.com/api/item/3"

Update:
sudo curl -X PUT -H "Content-Typ: application/json" -d '{"dateTime":"2018-08-14 22:05:06","message":"Skoroid third item","owner":"guest","version":"23"}' "http://edelux.com/api/item/3"

Delete:
sudo curl -v -X DELETE -H "Content-Type: application/json" "http://edelux.com/api/item/1"