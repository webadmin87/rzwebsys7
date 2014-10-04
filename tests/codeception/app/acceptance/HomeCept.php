<?php
use tests\codeception\app\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->urlManager->createUrl(Yii::$app->homeUrl));
$I->see('RzWebSys7');
$I->seeLink('Главная');