<?php

require_once dirname(__DIR__) .'/vendor/autoload.php';

$config = require(dirname(__DIR__) . '/config/main.php');
$services = require(dirname(__DIR__) . '/config/services.php');
$routes = require(dirname(__DIR__) . '/config/routes.php');

$app = new Silex\Application();

Symfony\Component\Debug\ErrorHandler::register();
Symfony\Component\Debug\ExceptionHandler::register(false);

$app['config'] = $config;

$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => $config['logFile'],
]);

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => $config['viewsPath'],
]);

$app['services'] = function () use ($services) {
    return array_reduce($services, function ($acc, $service) {
        $acc[$service['name']] = isset($service['params'])
            ? new $service['class']($service['params'])
            : new $service['class'];

        return $acc;
    }, []);
};

foreach ($routes['routes'] as $route) {
    $app->mount($route['prefix'], new $routes['provider']($route['controller'], $route['actions']));
}

$app->run();
