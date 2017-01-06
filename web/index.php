<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

$config = require(dirname(__DIR__) . '/config/main.php');
$services = require(dirname(__DIR__) . '/config/services.php');

$app = new Silex\Application();

$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => $config['logFile'],
]);

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => $config['viewsPath'],
]);

$app['services'] = function () use ($services) {
    return array_reduce($services, function ($acc, $service) {
        $acc[$service['name']] = new $service['class'];
        return $acc;
    }, []);
};

$app->mount('/', new \App\Controller\DefaultController());

$app->get('/reports/top_of_jobs_by_rubric', function (\Silex\Application $app) use ($config) {
    /** @var \App\Service\Storage $storage */
    $storage = $app['services']['storage'];
    $rubrics = $storage->getRubricsForTodayNewJobs($config['geoId']);

    /** @var \App\Service\ReportBuilder $reportBuilder */
    $reportBuilder = $app['services']['report_builder'];
    $rubricsTop = $reportBuilder->buildTopOfJobsByRubricReport($rubrics);

    return $app['twig']->render('reports/top_of_jobs_by_rubric.twig', compact('rubricsTop'));
})->bind('reports.top_of_jobs_by_rubric');

$app->run();
