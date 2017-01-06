<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that top_of_jobs_by_rubric page works');
$I->amOnPage('/reports/top_of_jobs_by_rubric');
$I->seeLink('назад');
$I->see('Топ вакансий по рубрикам', 'h1');
$I->see('Рубрика');
$I->see('Количество');
