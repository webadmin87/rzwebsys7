RzWebSys7 - CMS на основе Yii2
===================================

Структура системы
-----------------
1) app - web приложение

2) console - консольное приложение

3) common - ядро системы

4) vendor - сторонние компоненты

5) environments - настройки окружений

Системные требования
--------------------

1) PHP 5.4

2) Веб сервер Apache 2.2

3) PostgreSql 9.3

4) Composer

Установка
---------

Предполагается что composer находится в путях поиска вашей командной оболочки. Например, его можно разместить в **/usr/local/bin**

Для начала неоходимо установть плагин **fxp/composer-asset-plugin:1.0.0-beta2** для composer. Для этого выполняем следующую комаду:

`composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta2"`

После этого можно приступит к установки самой системы:

1) В файлах environments/dev/common/config/main-local.php и environments/prod/common/config/main-local.php
прописываем настройки соединения с базой данных для окружения разработки и продакшена соответственно.

2) Устанавливаем зависимости через composer. В корне системы выполняем команду `composer.phar install`

3) Запускаем скрипт **./init** и выбираем нужное окружение для установки

4) Запускаем **./yii install**

5) Наслаждаемся )

Генерация каркаса модуля
------------------------
Осуществляется с помощью системного генератора **App module generator**

Создание таблиц сущностей новых модулей.
---------------------------------------
Осуществляется с помощью **миграций**. Миграции создаются на базе системных шаблонов.

Примеры (таблица простой сущности, таблица древовидной сущности):

```
./yii migrate/create --migrationPath=@webapp/modules/module_name/migrations --templateFile=@console/views/migrations/table.php migration_name
```

```
./yii migrate/create --migrationPath=@webapp/modules/module_name/migrations --templateFile=@console/views/migrations/table-tree.php migration_name
```

где **module_name** - имя модуля для которого создается миграция, **migration_name** - имя миграции

Пример применения миграций для конкретного модуля:

```
./yii migrate/up --applyPath=@webapp/modules/module_name/migrations
```

Без параметра **applyPath** применение миграций происходит для всех модулей сразу

Создание моделей
----------------
Модели системы должны быть унаследованы от **\common\db\ActiveRecord** или **\common\db\TActiveRecord**
(обычные и древовидные соответственно).

Для каждой модели должен быть создан класс с описанием полей атрибутов. Базовый класс **\common\db\MetaFields**.

Примеры кода можно найти в модуле main.

Генерация CRUD сущностей
------------------------
Осуществляется с помощью модуля Gii на основе системных шаблонов. Шаблоны **App CRUD** и **App tree CRUD**
для обычных и древовидных сущностей соответственно.
Базовый класс для контроллеров админки common\controllers\Admin.

Рекомендации
------------
Модули ресурсов (AssetBundle) необходимо наследовать от **\common\components\AssetBundle**

Генерация документации
----------------------
Для генерации документации воспользуйтесь следующими командами

```
vendor/bin/apidoc api app ./docs/app
```

```
vendor/bin/apidoc api common ./docs/common
```

```
vendor/bin/apidoc api console ./docs/console
```