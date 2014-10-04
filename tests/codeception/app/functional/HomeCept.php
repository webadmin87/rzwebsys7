<?php
use tests\codeception\app\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->urlManager->createUrl(Yii::$app->homeUrl));
$I->see('RzWebSys7');
$I->seeLink('Главная');