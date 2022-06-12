<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge\ParallelRunning;

use Abrouter\Client\Contracts\TaskContract;

class ParallelTaskContainer implements TaskContract
{
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
