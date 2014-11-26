<?php

	$conf = require('sphinx-local.php');

    $conf['preffix'] = 'rzwebsys7';

	$indexSettings = '

		# Минимальная длина индексируемого слова
		min_word_len = 3

		# Тип хранения аттрибутов
		docinfo	= extern

		mlock = 0

		# Используемые морфологические движки
		morphology = stem_enru, soundex, metaphone

		# Из данных источника HTML-код нужно вырезать
		html_strip = 1

		expand_keywords = 1

	';

?>

# Источник-родитель для всех остальных источников. Здесь указываются параметры доступа
# к базе данных сайта

source <?=$conf['preffix']?>ParentSource
{

	type = <?=$conf["type"]?>

	sql_host = <?=$conf["sql_host"]?>

	sql_user = <?=$conf["sql_user"]?>

	sql_pass = <?=$conf["sql_pass"]?>

	sql_db = <?=$conf["sql_db"]?>

	sql_port = <?=$conf["sql_port"]?>

}

# Источник новостей

source <?=$conf['preffix']?>NewsSource : <?=$conf['preffix']?>ParentSource
{
# запрос на получения данных
sql_query		= \
SELECT n.id, n.id AS item_id, n.title, n.title AS item_title, n.text, n.annotation, n.created_at, n.code, s.code AS section_code, 'News' as model \
FROM news n INNER JOIN news_to_sections ns ON n.id = ns.news_id INNER JOIN news_sections s ON ns.section_id = s.id  \
WHERE n.id>=$start AND n.id<=$end AND n.active=true

# запрос для дробления получения топиков на неколько итераций
sql_query_range		= SELECT MIN("id"),MAX("id") FROM "news"

# сколько получать объектов за итерацию
sql_range_step		= 500

sql_attr_timestamp	= created_at
sql_attr_string = item_id
sql_attr_string = item_title
sql_attr_string = code
sql_attr_string = model
sql_attr_string = section_code

sql_ranged_throttle	= 0
}

# Настройка индесатора новостей

index <?=$conf['preffix']?>NewsIndex
{
# Источник, который будет хранить данный индекса
source = <?=$conf['preffix']?>NewsSource
path =<?=$conf["path"]?>/<?=$conf['preffix']?>NewsIndex

<?=$indexSettings?>

}

# Источник текстовых страниц

source <?=$conf['preffix']?>PagesSource : <?=$conf['preffix']?>ParentSource
{
# запрос на получения данных
sql_query		= \
SELECT id, id AS item_id, title, title AS item_title, text, created_at, code, '' AS section_code, 'Pages' as model \
FROM pages \
WHERE id>=$start AND id<=$end AND active=true

# запрос для дробления получения топиков на неколько итераций
sql_query_range		= SELECT MIN("id"),MAX("id") FROM "pages"

# сколько получать объектов за итерацию
sql_range_step		= 500

sql_attr_timestamp	= created_at
sql_attr_string = item_id
sql_attr_string = item_title
sql_attr_string = code
sql_attr_string = model
sql_attr_string = section_code

sql_ranged_throttle	= 0
}

# Настройка индесатора страниц

index <?=$conf['preffix']?>PagesIndex
{
# Источник, который будет хранить данный индекса
source = <?=$conf['preffix']?>PagesSource
path =<?=$conf["path"]?>/<?=$conf['preffix']?>PagesIndex

<?=$indexSettings?>

}

# Источник каталога

source <?=$conf['preffix']?>CatalogSource : <?=$conf['preffix']?>ParentSource
{
	# запрос на получения данных
	sql_query		= \
		SELECT c.id, c.id AS item_id, c.title, c.title as item_title, c.articul, c.price, c.code, s.code AS section_code, 'Catalog' as model, \
		c.active, c.created_at \
		FROM catalog_catalog c \
        INNER JOIN catalog_catalog_to_sections cs ON cs.catalog_id = c.id \
        INNER JOIN catalog_sections s ON cs.section_id = s.id \
		WHERE c.active = true AND c.id>=$start AND c.id<=$end

	# запрос для дробления получения топиков на неколько итераций
	sql_query_range		= SELECT MIN("id"),MAX("id") FROM "catalog_catalog"

	# сколько получать объектов за итерацию
	sql_range_step		= 500

	sql_attr_timestamp	= created_at
	sql_attr_string = item_id
	sql_attr_string = item_title
	sql_attr_string = code
    sql_attr_string = model
	sql_attr_string = section_code
	sql_ranged_throttle	= 0
}

# Настройка индесатора каталога

index <?=$conf['preffix']?>CatalogIndex
{
	# Источник, который будет хранить данный индекса
	source = <?=$conf['preffix']?>CatalogSource
	path =<?=$conf["path"]?>/<?=$conf['preffix']?>CatalogIndex

	<?=$indexSettings?>

}
