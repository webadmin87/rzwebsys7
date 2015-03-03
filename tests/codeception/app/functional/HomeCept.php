<?php
use tests\codeception\app\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->urlManager->createUrl('main/pages/index'));
$I->see('RzWebSys7');
$I->seeLink('Главная');