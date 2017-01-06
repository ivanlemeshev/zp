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
});

$app->run();
