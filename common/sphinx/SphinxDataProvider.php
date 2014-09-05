<?php
namespace common\sphinx;

use yii\data\ActiveDataProvider;
use yii\db\QueryInterface;
use yii\db\Expression;

/**
 * Class SphinxDataProvider
 * Провайдер данных для получения моделей через sphinx. Сначала из сфинкса выбираются id затем по этим id выбираются модели.
 * @package common\sphinx
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SphinxDataProvider extends ActiveDataProvider
{

	/**
	 * @var \yii\sphinx\Query запрос к сфинксу
	 */
	public $sphinxQuery;

	/**
	 * @var string имя атрибута в индексе сфинкса хранящего идентификаторы моделей
	 */
	public  $idAttr = "id";


	/**
	 * Возвращает массив идентификаторов моделей
	 * @return array
	 * @throws InvalidConfigException
	 */
	protected function prepareSphinxQuery()
	{

		if (!$this->sphinxQuery instanceof QueryInterface) {
			throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		}

		$query = clone $this->sphinxQuery;

		$query->select($this->idAttr);

		if (($pagination = $this->getPagination()) !== false) {
			$pagination->totalCount = $this->getTotalCount();
			$query->limit($pagination->getLimit())->offset($pagination->getOffset());
		}

		$rows = $query->all();

		$ids = [];

		foreach ($rows as $row) {
			$ids[] = $row[$this->idAttr];
		}

		return $ids;

	}


	/**
	 * @inheritdoc
	 */
	protected function prepareModels()
	{
		if (!$this->query instanceof QueryInterface) {
			throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		}

		$query = clone $this->query;

		$ids = $this->prepareSphinxQuery();

		$query->orderBy([$this->getOrderByExpression($ids)]);

		$query->where(["id"=>$ids]);

		return $query->all($this->db);
	}

	/**
	 * Возвращает выражение для сортировки результата
	 * @param array $ids массив идентификаторов найденных сфинксом моделей
	 * @return \yii\db\Expression
	 * @throws \yii\base\InvalidConfigException
	 */
	protected function getOrderByExpression($ids)
	{

		$orderStr = "CASE id\n";

		$i=1;

		foreach($ids AS $id) {

			$orderStr .= "WHEN $id THEN $i\n";

			$i++;
		}

		$orderStr .= "ELSE $i\n";

		$orderStr .= "END\n";

		return \Yii::createObject(Expression::className(), [$orderStr]);

	}


}
