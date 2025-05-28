<?php
return [
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'database'=> getenv('DB_NAME'),
    'username' => getenv('DB_USER'),
    'password'=> '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
];

?>
