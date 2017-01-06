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

$app->get('/', function (\Silex\Application $app) {
    return $app['twig']->render('index.twig');
})->bind('default.index');

$app->get('/reports/top_of_jobs_by_rubric', function (\Silex\Application $app) {
    $params = [
        'categories_facets' => true,
        'is_new_only' => true,
        'period' => 'today',
        'geo_id' => 826, // Новосибирск
        'state' => 1,
    ];

    $url = 'https://api.zp.ru/v1/vacancies?' . http_build_query($params);
    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $url);
    $data = json_decode($response->getBody()->getContents(), true);

    $rubricsTop = [];

    if (isset($data['metadata']['categories_facets'])) {
        /** @var \App\Service\ReportBuilder $reportBuilder */
        $reportBuilder = $app['services']['report_builder'];
        $rubricsTop = $reportBuilder->buildTopOfJobsByRubricReport($data['metadata']['categories_facets']);
    }

    return $app['twig']->render('reports/top_of_jobs_by_rubric.twig', compact('rubricsTop'));
})->bind('reports.top_of_jobs_by_rubric');

$app->run();
