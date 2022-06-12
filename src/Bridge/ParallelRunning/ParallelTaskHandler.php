<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge\ParallelRunning;

use Abrouter\Client\Contracts\TaskContract;
use Abrouter\Client\Events\EventDispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParallelTaskHandler implements TaskContract
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private EventDispatcher $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(ParallelTaskContainer $parallelTaskContainer)
    {
        $this->eventDispatcher->dispatch($parallelTaskContainer->getTaskContract());
    }
}
