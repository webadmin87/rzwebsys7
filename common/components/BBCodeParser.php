<?php
namespace common\components;

use yii\base\Component;

/**
 * Class BBCodeParser
 * Парсер BB кодов в html
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class BBCodeParser extends Component  {

    /**
     * Преобразует BB коды в Html
     * @param string $text
     * @return string
     */

    public function parse($text) {

		$strSearch = array(
			'#\\n#is',
			'#\[b\](.+?)\[\/b\]#is',
			'#\[i\](.+?)\[\/i\]#is',
			'#\[u\](.+?)\[\/u\]#is',
			'#\[s\](.+?)\[\/s\]#is',
			'#\[quote\](.+?)\[\/quote\]#is',
			'#\[url=(.+?)\](.+?)\[\/url\]#is',
			'#\[url\](.+?)\[\/url\]#is',
			'#\[img\](.+?)\[\/img\]#is',
		);
		$strReplace = array(
			"<br />",
			"<b>\\1</b>",
			"<i>\\1</i>",
			"<u>\\1</u>",
			"<strike>\\1</strike>",
			"<blockquote>\\1</blockquote>",
			"<noindex><a rel='nofollow' href='\\1'>\\2</a></noindex>",
			"<noindex><a rel='nofollow' href='\\1'>\\1</a></noindex>",
			"<img src='\\1' alt = 'Изображение' />",
		);
		return preg_replace($strSearch, $strReplace, $text);


	}

    /**
     * Вырезает все BB коды из текста
     * @param string $text
     * @return string
     */

    public function clean($text) {
		
		return preg_replace('/\[[^]]+\]/im', "", $text);
		
	}

}
