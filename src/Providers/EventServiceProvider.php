<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Providers;

use Abrouter\LaravelClient\Bridge\ParallelRunning\ParallelTaskContainer;
use Illuminate\Events\EventServiceProvider as ServiceProvider;
use Abrouter\LaravelClient\Bridge\ParallelRunning\ParallelTaskHandler;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        ParallelTaskContainer::class => [
            ParallelTaskHandler::class,
        ]
    ];
}
