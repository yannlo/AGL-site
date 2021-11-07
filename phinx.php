<?php
require __DIR__ ."/public/index.php";

$migrations =[];
$seeds =[];

foreach ($modules as $module) {
    if ($module::MIGRATIONS) {
        $migrations[] = $module::MIGRATIONS;
    }
    if ($module::SEEDS) {
        $seeds[] = $module::SEEDS;
    }
}

return
[
    'paths' => [
        'migrations' =>$migrations,
        'seeds' => $seeds
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $container ->get('database.host'),
            'name' => $container ->get('database.name'),
            'user' => $container ->get('database.username'),
            'pass' => $container ->get('database.password'),
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $container ->get('database.host'),
            'name' => $container ->get('database.name'),
            'user' => $container ->get('database.username'),
            'pass' => $container ->get('database.password'),
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => $container ->get('database.host'),
            'name' => $container ->get('database.name'),
            'user' => $container ->get('database.username'),
            'pass' => $container ->get('database.password'),
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
