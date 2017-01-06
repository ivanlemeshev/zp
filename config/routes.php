<?php

return [
    'provider' => App\Provider\ControllerProvider::class,
    'routes' => [
        [
            'prefix' => '/',
            'controller' => App\Controller\DefaultController::class,
            'actions' => [
                [
                    'route'  => '/',
                    'method' => 'GET',
                    'action' => 'index',
                    'name'   => 'default.index',
                ],
            ],
        ],
        [
            'prefix' => '/reports',
            'controller' => App\Controller\ReportController::class,
            'actions' => [
                [
                    'route'  => '/top_of_jobs_by_rubric',
                    'method' => 'GET',
                    'action' => 'topOfJobsByRubric',
                    'name'   => 'reports.top_of_jobs_by_rubric',
                ],
            ],
        ],
    ],
];
