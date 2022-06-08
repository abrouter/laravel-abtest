<?php
declare(strict_types = 1);

use Abrouter\LaravelClient\Bridge\KvStorage;
use Abrouter\LaravelClient\Bridge\ParallelRunning\TaskManager;

return [
    'token' => '',
    'host' => 'https://abrouter.com',
    'parallelRunning' => [
        'enabled' => true,
        'taskManager' => TaskManager::class,
    ],
    'kvStorage' => KvStorage::class
];
