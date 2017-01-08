<?php

return [
    [
        'name' => 'reportBuilder',
        'class' => \App\Service\ReportBuilder::class,
    ],
    [
        'name' => 'storage',
        'class' => \App\Service\Storage::class,
    ],
    [
        'name' => 'cache',
        'class' => \App\Service\Cache\FileCache::class,
        'params' => [
            'path' => dirname(__DIR__) . '/cache',
        ],
    ],
];
