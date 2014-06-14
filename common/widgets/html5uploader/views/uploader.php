<?

/**
 * @var string $name имя поля ввода
 * @var array $options массив html атрибутов поля ввода
 * @var int $maxFileSize максимальный размер загружаемого файла
 * @var array $files  массив путей к файлам
 * @var string $webroot алиас DOCUMENT ROOT
 */

use yii\helpers\Html;
use common\helpers\FileHelper;


echo Html::hiddenInput($name);

echo Html::fileInput($name, null, $options);

?>

<div class="uploader-widget-drop-box">
    <ul class="uploader-widget-files-list">

        <?

        if(is_array($files)):

            $i = 0;
            foreach($files AS $file):?>

                <li>
                    <div class="uploader-widget-name"><?=basename($file["file"])?></div>
                    <div class="uploader-widget-preview">

                        <?if(FileHelper::isImage(Yii::getAlias($webroot.$file["file"]))):?>

                            <img src="<?=$file["file"]?>" width="150" alt="" />

                        <?endif;?>

                    </div>
                    <div class="uploader-widget-progress progress-bar"></div>

                    <input type="hidden" name="<?=$name?>[<?=$i?>][file]" value="<?=$file["file"]?>" class="uploader-file-name" />
                    <input type="text" name="<?=$name?>[<?=$i?>][title]" value="<?=Html::encode( $file["title"] )?>" class="uploader-file-title" />

                    <div><a href="#" class="uploader-file-remove"><?=Yii::t('core', 'remove')?></a></div>

                </li>

                <?
                $i++;
            endforeach;

        endif;

        ?>

    </ul>
</div>

<div class="alert alert-info"><?=Yii::t('core', 'Max uploaded file size')?> <?=$maxFileSize?>Mb</div>