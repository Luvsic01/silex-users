<?php

use \Silex\Provider\DoctrineServiceProvider;
use \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

// configure your app for the production environment

$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

$app->register(new DoctrineServiceProvider(),
    [
        'db.options' => [
            'driver'    => 'pdo_mysql',
            'dbname'    => 'mvc',
            'host'      => 'localhost',
            'user'      => 'root',
            'password'  => ''
        ]
    ]
);

$app->register(new DoctrineOrmServiceProvider(), [
        'orm.proxies_dir' => sys_get_temp_dir(),
        'orm.em.options' => [
            'mappings' => [
                [
                    'type' => 'annotation',
                    'namespace' => 'Models',
                    'path' => __DIR__.'/../src/Models',
                ]
            ]
        ]
    ]
);