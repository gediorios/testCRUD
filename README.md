testCRUD
========
Фреймворк Zend 2.3:
-Сервер должен смотреть в /public на index.php
-Настройки коннекта к базе лежат в /config/autoload

Тестовое одностраничное асинхронное CRUD-приложение Bookshelf:
Есть некоторый набор библиотек и есть некоторый набор книг.
Библиотеки объединяют в себе книги. Каждая библиотека может содержать любой произвольный набор книг, 
соответственно каждая книга может принадлежать n библиотекам.
Логика приложения следующая:
back-end модель данных представляет собой ORM, которая содержит в себе 2 сущности:
Library и Book - асинхронный(ajax+jquery) CRUD. Каждая сущность-библиотека содержит в себе набор 
принадлежащих ей сущностей-книг.
Листалка библиотек реализована как jquery-плагин (/public/js/libToggle.js)
Как итог мы имеем максимально гибкую back-end ORM-модель, реализованную с точки зрения front-end разработчика
по принципу черного ящика: 
В одно и то же место(методом POST на /ajax) подаем на вход название сущности, действие с ней и 
соответствующий действию набор параметров.Обрабатываем полученный ответ.

Соответственно front-end модель представляет собой асинхронный UI на стороне клиента  и 
становится максимально независим от модели данных на стороне сервера.  
