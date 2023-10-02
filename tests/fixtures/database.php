<?php

return [
        
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => './tests/fixtures/test.db',
    ],

    'mysql' => [
        'driver' => 'mysql',
        'host' => null,
        'port' => '3306',
        'database' => null,
        'username' => null,
        'password' => null,
    ],

    'pgsql' => [
        'driver' => 'pgsql',
        'host' => null,
        'port' => '5432',
        'database' => null,
        'username' => null,
        'password' => null,
    ],
    
    'sqlsrv' => [
        'driver' => 'sqlsrv',
        'host' => null,
        'port' => '1433',
        'database' => null,
        'username' => null,
        'password' => null,
    ],
];