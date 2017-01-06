<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that top_of_words_in_job_titles page works');
$I->amOnPage('/reports/top_of_words_in_job_titles');
$I->seeLink('назад');
$I->see('Топ слов по упоминанию их в заголовках вакансий', 'h1');
$I->see('Слово');
$I->see('Количество');
