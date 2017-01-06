<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that index page works');
$I->amOnPage('/');
$I->see('Отчеты', 'h1');
$I->seeLink('топ вакансий по рубрикам');
$I->seeLink('топ слов по упоминанию их в заголовках вакансий');
