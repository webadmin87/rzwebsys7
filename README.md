RzWebSys7 - CMS на основе Yii2
===================================

Создание таблиц сущностей.
--------------------------
Осуществляется с помощью миграций. Миграции создаются на базе системных шаблонов.

Примеры (таблица простой сущности, таблица древовидной сущности):

```
./yii migrate/create --templateFile=@console/views/migrations/table.php migration_name

./yii migrate/create --templateFile=@console/views/migrations/table-tree.php migration_name
```

Генерация CRUD сущностей
------------------------
Осуществляется с помощью модуля Gii на основе системных шаблонов. Шаблоны *App CRUD* и *App tree CRUD*
для обычных и древовидных сущностей соответственно.
Базовый класс для контроллеров админки common\controllers\Admin.