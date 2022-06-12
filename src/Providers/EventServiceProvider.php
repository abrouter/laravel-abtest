<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Providers;

use Abrouter\LaravelClient\Bridge\ParallelRunning\ParallelTaskContainer;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Abrouter\LaravelClient\Bridge\ParallelRunning\ParallelTaskHandler;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ParallelTaskContainer::class => [
            ParallelTaskHandler::class,
        ]
    ];
}
