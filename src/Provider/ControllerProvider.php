<?php

namespace App\Provider;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class ControllerProvider implements ControllerProviderInterface
{
    public $class;

    public $actions = [];

    public function __construct(string $class, array $actions)
    {
        $this->class = $class;
        $this->actions = $actions;
    }

    public function connect(Application $app): ControllerCollection {
        $controllers = $app['controllers_factory'];

        foreach ($this->actions as $action) {
            $method = strtolower($action['method']);

            $controllers
                ->$method($action['route'], $this->class . '::' . $action['action'])
                ->bind($action['name']);
        }

        return $controllers;
    }
}
