<?php

$db_driver = $_ENV['DB_DRIVER'] ?? 'mysql';
$db_host = $_ENV['DB_HOST'] ?? 'localhost';
$db_name = $_ENV['DB_NAME'] ?? 'managementproducts';

return [
    'class' => 'yii\db\Connection',
    'dsn' => "$db_driver:host=$db_host;dbname=$db_name",
    'username' => $_ENV['DB_USER'] ?? 'admin',
    'password' => $_ENV['DB_PASSWORD'] ?? 'Le12_vem',
    'charset' => 'utf8',
];
