<?php
/**
 * @var yii\web\View $this
 * @var string $html html код грида с товарами
 * @var \app\modules\catalog\models\CatalogSection|null $sectionModel модель категории
 * @var \app\modules\catalog\models\Catalog $model модель элемента каталога
 */
?>
<h1><?= $sectionModel ? $sectionModel->title : Yii::t('catalog/app', 'Catalog') ?></h1>
<?=$this->render('_sections');?>
<?=$html?>
