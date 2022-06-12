<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge\ParallelRunning;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Contracts\TaskManagerContract;
use Illuminate\Events\Dispatcher;

class TaskManager implements TaskManagerContract
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function queue(TaskContract $task): void
    {
        $this->dispatcher->dispatch(new ParallelTaskContainer($task));
    }

    public function work(int $iterationsLimit = 0): void
    {
    }
}
