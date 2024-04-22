<?php

$db_driver = env('DB_DRIVER') ?? 'mysql';
$db_host = env('DB_HOST') ??  'localhost';
$db_name = env('DB_NAME') ??  'managementproducts';

return [
    'class' => 'yii\db\Connection',
    'dsn' => "$db_driver:host=$db_host;dbname=$db_name",
    'username' => env('DB_USER') ??  'admin',
    'password' => env('DB_PASSWORD') ??  'Le12_vem',
    'charset' => 'utf8',
];
