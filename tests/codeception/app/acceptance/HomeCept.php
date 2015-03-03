<?php
use tests\codeception\app\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage('/');
$I->see('RzWebSys7');
$I->seeLink('Главная');