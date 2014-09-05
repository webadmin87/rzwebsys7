<?php
namespace common\sphinx;

use Yii;
use yii\base\Component;
use yii\db\Expression;
use yii\base\InvalidConfigException;

/**
 * Class SphinxSearch
 * Полнотекстовый поиск моделей по индексу сфинкса
 * @package common\sphinx
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SphinxSearch extends Component
{

	/**
	 * @var string|array имена индексов для поиска
	 */
	public $index;

	/**
	 * @var string класс модели
	 */
	public $modelClass;

	/**
	 * @var int минимаольная длина учитываемого слова в поисовой фразе
	 */
	public $minLen = 3;

	/**
	 * @var array параметры запроса к сфинксу
	 */
	public $options = [];

	/**
	 * @var \yii\sphinx\Query запрос к сфинксу
	 */
	protected $_sphinxQuery;

	/**
	 * @var \yii\db\ActiveQueryInterface запрос к сущности
	 */
	protected $_query;

	/**
	 * @inheritdoc
	 * @throws InvalidConfigException
	 */
	public function init()
	{
		if(empty($this->index) OR empty($this->modelClass))
			throw new InvalidConfigException;

	}

	/**
	 * Возвращает запрос к сфинксу
	 * @return \yii\sphinx\Query
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getSphinxQuery()
	{

		if($this->_sphinxQuery === null) {

			$this->_sphinxQuery = \Yii::createObject(\yii\sphinx\Query::className());

			$this->_sphinxQuery->from($this->index)->options(array_merge(["ranker"=>"wordcount"], $this->options));

		}

		return $this->_sphinxQuery;

	}

	/**
	 * Возвращает запрос к сущности
	 * @return \yii\db\ActiveQueryInterface
	 */
	public function getQuery()
	{

		if($this->_query === null) {

			$class = $this->modelClass;

			$this->_query = $class::find();
		}

		return $this->_query;

	}

	/**
	 * Поиск. Возвращает провайдер данных
	 * @param string $term фраза для поиска
	 * @param array $attrs массив значений атрибутов (key=>value)
	 * @return \common\sphinx\SphinxDataProvider
	 * @throws \yii\base\InvalidConfigException
	 */
	public function search($term, $attrs = [])
	{

		$query = $this->getQuery();

		$sphinxQuery = $this->getSphinxQuery();

		if($term)
			$sphinxQuery->match( \Yii::createObject(Expression::className(), [$this->prepareTerm($term)]));

		if($attrs)
			$sphinxQuery->andWhere($attrs);

		$dataProvider = \Yii::createObject([

			"class"=>\common\sphinx\SphinxDataProvider::className(),
			"query"=>$query,
			"sphinxQuery"=>$sphinxQuery,

		]);

		return $dataProvider;

	}

	/**
	 * Приводит строку запроса к виду необходимому для сфинкса
	 * @param string $term строка запроса
	 * @return string
	 */
	public function prepareTerm($term)
	{

		$conn = Yii::$app->sphinx;

		$term = trim($term);

		$termArr = explode(" ", $term);

		foreach($termArr AS $k => $word) {

			if(mb_strlen($word) < $this->minLen)
				unset($termArr[$k]);
			else {
				$word = trim($word);
				$termArr[$k] = $conn->escapeMatchValue($word);
			}
		}

		$termStr = $conn->quoteValue(implode("|", $termArr));

		return $termStr;

	}


}