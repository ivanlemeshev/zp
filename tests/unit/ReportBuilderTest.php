<?php

class ReportBuilderTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Service\ReportBuilder
     */
    protected $reportBuilder;

    protected function _before()
    {
        $this->reportBuilder = new \App\Service\ReportBuilder();
    }

    public function testBuildTopOfJobsByRubricReport()
    {
        $rubrics = [
            ['title' => 'Торговля розничная', 'count' => 123],
            ['title' => 'Логистика, склад, закупки', 'count' => 12],
            ['title' => 'Высший менеджмент, руководители', 'count' => 1234],
        ];

        $expected = [
            'Высший менеджмент, руководители' => 1234,
            'Торговля розничная' => 123,
            'Логистика, склад, закупки' => 12,
        ];

        $this->assertEquals($expected, $this->reportBuilder->buildTopOfJobsByRubricReport($rubrics));
    }

    public function testBuildTopWordsInJobTitlesReport()
    {
        $jobs = [
            ['header' => 'PHP-разработчик'],
            ['header' => 'PHP-разработчик'],
            ['header' => 'Менеджер по рекламе'],
            ['header' => 'Менеджер по продажам'],
            ['header' => 'PHP-разработчик'],
        ];

        $expected = [
            'PHP-разработчик' => 3,
            'Менеджер' => 2,
            'по' => 2,
            'рекламе' => 1,
            'продажам' => 1,
        ];

        $this->assertEquals($expected, $this->reportBuilder->buildTopOFWordsInJobTitlesReport($jobs));
    }

    public function testGetWords()
    {
        $string = 'Это рандомная строка строка   привет-привет abc 123 ±!@#$%^&*()_+==\'"~`';
        $expected = explode(' ', 'Это рандомная строка строка привет-привет abc 123');
        $this->assertEquals($expected, $this->reportBuilder->getWords($string));
    }
}
