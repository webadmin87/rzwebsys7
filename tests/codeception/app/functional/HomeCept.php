<?php
use tests\codeception\frontend\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('RzWebSys7');
$I->seeLink('Главная');