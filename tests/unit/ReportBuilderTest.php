<?php

class ReportBuilderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \App\Service\ReportBuilder
     */
    protected $reportBuilder;

    protected function _before()
    {
        $this->reportBuilder = new \App\Service\ReportBuilder();
    }

    public function testBuildTopJobsByRubricReport()
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
}
