<?php

use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Symfony\Component\Security\Core\Encoder\PlaintextPasswordEncoder;

// configure your app for the production environment

$app['twig.path'] = array(__DIR__ . '/../templates');
$app['twig.options'] = array('cache' => __DIR__ . '/../var/cache/twig');

$app->register(new DoctrineServiceProvider(),
    [
        'db.options' => [
            'driver' => 'pdo_mysql',
            'dbname' => 'mvc',
            'host' => 'localhost',
            'user' => 'root',
            'password' => ''
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
                    'path' => __DIR__ . '/../src/Models',
                ]
            ]
        ]
    ]
);

$app->register(
    new SecurityServiceProvider(),
    [
        'security.firewalls' => [
            'firewall_admin' => [                       // Firewall name
                'pattern' => '^/admin',                 // Firewall scope
                'http' => true,                         // Pure http authentification system
                'users' => [                            // User provider definition
                    'admin' => ['ROLE_ADMIN', 'foo'],   // User => [role, pwd]
                    'user' => ['ROLE_USER', 'bar']
                ]
            ]
        ],
        'security.role_hierarchy' => [                  // Role hierarchy definition
            'ROLE_ADMIN' => ['ROLE_USER']               // Role admin is upper than role user
        ],
        'security.default_encoder' => function () {
            return new PlaintextPasswordEncoder();
        },
        'security.access_rules' => [
            ['^/admin', 'ROLE_ADMIN']
        ]
    ]
);