<?php

namespace App\Controller;

use Silex\Application;

class DefaultController
{
    public function index(Application $app)
    {
        return $app['twig']->render('index.twig');
    }
}