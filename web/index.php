<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

$config = require(dirname(__DIR__) . '/config/main.php');
$services = require(dirname(__DIR__) . '/config/services.php');

$app = new Silex\Application();

$app['config'] = $config;

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
$app->mount('/reports', new \App\Controller\ReportController());

$app->run();
