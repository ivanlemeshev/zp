<?php

namespace App\Controller;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class DefaultController implements ControllerProviderInterface
{
    public function connect(Application $app): ControllerCollection {
        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/', function (Application $app) {
                return $app['twig']->render('index.twig');
            })->bind('default.index');

        return $controllers;
    }
}
