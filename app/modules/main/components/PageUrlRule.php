<?php

namespace app\modules\main\components;

use yii\web\UrlRule;
use \app\modules\main\models\Pages;
use common\db\TActiveRecord;

/**
 * Class PageUrlRule
 * Правило для роутинга текстовых страниц
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PageUrlRule extends UrlRule
{
	/**
	 * @inheritdoc
	 */
	public $connectionID = 'db';

	/**
	 * @inheritdoc
	 */
	public $route = 'main/pages/index';

	/**
	 * @inheritdoc
	 */
	public $pattern = '[A-z0-9_-]+';

	/**
	 * @inheritdoc
	 */
	public function createUrl($manager, $route, $params)
	{
		if ($route === $this->route AND isset($params["model"]) AND $params["model"] instanceof Pages) {

            if($params["model"]->code != Pages::INDEX_CODE) {

                $url = [];

                $ancestors = $params["model"]->ancestors()->all();

                foreach ($ancestors as $model) {

                    if ($model->isRoot())
                        continue;

                    $url[] = $model->code;

                }

                $url[] = $params["model"]->code;

                $str = implode("/", $url);
            } else {
                $str = "";
            }

            unset($params["model"]);

            if ($str !== '') {
				$str .= ($this->suffix === null ? $manager->suffix : $this->suffix);
			}

			if (!empty($params) && ($query = http_build_query($params)) !== '') {
				$str .= '?' . $query;
			}

			return $str;

		}
		return false;
	}

	/**
	 * @inheritdoc
	 */
	public function parseRequest($manager, $request)
	{
		$pathInfo = trim($request->getPathInfo(),'/');

		if(empty($pathInfo) OR $pathInfo == Pages::INDEX_CODE)
			return false;

		$sections = explode("/", $pathInfo);

        $parent = Pages::findOne(TActiveRecord::ROOT_ID);

		foreach($sections AS $section) {

			$model = $parent->children()->published()->andWhere(["code" => $section])->one();

			if(!$model)
				return false;
            else
                $parent = $model;
		}

		if(!empty($model)) {

			return [$this->route, ['code'=>$model->code]];

		}

		return false;  // this rule does not apply
	}
}
