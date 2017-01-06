<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class ReportController implements ControllerProviderInterface
{
    public function connect(Application $app): ControllerCollection {
        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/top_of_jobs_by_rubric', function (Application $app) {
                /** @var \App\Service\Storage $storage */
                $storage = $app['services']['storage'];
                $rubrics = $storage->getRubricsForTodayNewJobs($app['config']['geoId']);

                /** @var \App\Service\ReportBuilder $reportBuilder */
                $reportBuilder = $app['services']['report_builder'];
                $rubricsTop = $reportBuilder->buildTopOfJobsByRubricReport($rubrics);

                return $app['twig']->render('reports/top_of_jobs_by_rubric.twig', compact('rubricsTop'));
            })->bind('reports.top_of_jobs_by_rubric');

        return $controllers;
    }
}
