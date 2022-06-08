<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge\ParallelRunning;

use Abrouter\Client\Contracts\TaskContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class ParallelTaskContainer implements TaskContract, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private TaskContract $taskContract;

    public function __construct(TaskContract $taskContract)
    {
        $this->taskContract = $taskContract;
    }

    /**
     * @return TaskContract
     */
    public function getTaskContract(): TaskContract
    {
        return $this->taskContract;
    }
}
