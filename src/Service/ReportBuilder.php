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
}
