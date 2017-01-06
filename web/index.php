<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => dirname(__DIR__) . '/logs/app.log',
]);

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => dirname(__DIR__) . '/src/Resources/views',
]);

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
        $rubricsTop = array_reduce($data['metadata']['categories_facets'], function ($acc, $item) {
            $acc[$item['title']] = $item['count'];
            return $acc;
        }, []);

        arsort($rubricsTop);
    }

    return $app['twig']->render('reports/top_of_jobs_by_rubric.twig', compact('rubricsTop'));
})->bind('reports.top_of_jobs_by_rubric');

$app->run();
