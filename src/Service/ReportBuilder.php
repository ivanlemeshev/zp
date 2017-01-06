<?php

namespace App\Service;

class ReportBuilder
{
    /**
     * Возвращает топ рубрик по количеству вакансий.
     * @param array $rubrics
     * @return array
     */
    public function buildTopOfJobsByRubricReport(array $rubrics): array
    {
        $rubricsTop = array_reduce($rubrics, function ($acc, $item) {
            $acc[$item['title']] = $item['count'];
            return $acc;
        }, []);

        arsort($rubricsTop);

        return $rubricsTop;
    }

    /**
     * Возвращает топ слов по упоминанию их в заголовках вакансий.
     * @param array $jobs
     * @return array
     */
    public function buildTopOfWordsInJobTitlesReport(array $jobs): array
    {
        $titlesTop = array_reduce($jobs, function ($acc, $item) {
            $words = $this->getWords($item['header']);
            foreach ($words as $word) {
                if (!isset($acc[$word])) {
                    $acc[$word] = 0;
                }
                $acc[$word]++;
            }
            return $acc;
        }, []);

        arsort($titlesTop);

        return $titlesTop;
    }

    /**
     * Создает массив слов из данной строки.
     * @param string $str
     * @return array
     */
    public function getWords(string $str): array
    {
        $title = preg_replace('!\s+!', ' ', $str);
        $title = preg_replace('/(.\.)|[^0-9a-zA-Zа-яА-я\-\s]/u', '', $title);
        return explode(' ', trim($title));
    }
}
