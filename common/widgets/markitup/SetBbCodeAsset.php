<?php
namespace common\widgets\markitup;

use common\components\AssetBundle;

/**
 * Class SetBbCodeAsset
 * Ассет настроек для BbCode
 * @package common\widgets\markitup
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class SetBbCodeAsset extends AssetBundle
{

    public $css = [
        'style.css',
    ];

    public $js = [
        'set.js',
    ];

    public $jsMin = [
        'set.min.js',
    ];

    public $depends = [
        '\common\widgets\markitup\MarkItUpAsset',
    ];

    public function init()
    {

        $this->sourcePath = __DIR__ . "/assets/sets/bbcode";

        parent::init();

    }

}