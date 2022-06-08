<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge\ParallelRunning;

use Abrouter\Client\Events\EventDispatcher;

class ParallelTaskHandler
{
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
