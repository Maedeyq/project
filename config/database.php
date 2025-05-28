<?php

return [
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'database'=> getenv('ariantel'),
    'username' => getenv('root'),
    'password'=> getenv(''),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];