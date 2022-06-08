<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Providers;

use Abrouter\Client\Config\Config;
use Abrouter\Client\Config\ParallelRunConfig;
use Abrouter\Client\Contracts\KvStorageContract;
use Abrouter\Client\Contracts\TaskManagerContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use RuntimeException;
use Illuminate\Config\Repository;
use Abrouter\LaravelClient\Bridge\KvStorage;

/**
 * Class AbrouterServiceProvider
 * @package Abrouter\LaravelClient
 */
class AbrouterServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->configPath() => $this->getApplicationConfigPath(),
            ], 'abrouter');
        }
    }
    
    public function register(): void
    {
        $this->mergeConfigFrom($this->configPath(), 'abrouter');


        $config = new Config(
            (string) $this->getConfig()->get('abrouter.token'),
            (string) $this->getConfig()->get('abrouter.host')
        );

        $parallelRunningConfigured = false;
        if ($this->configureKvStorage()) {
            $config->setKvStorageConfig($this->getContainer()->make(KvStorageContract::class));
            $parallelRunningConfigured = true;
        }

        if ($parallelRunningConfigured && $this->isParallelRunningEnabled()) {
            $this->configureParallelRunning();
            $config->setParallelRunConfig(new ParallelRunConfig(
                true,
                $this->getContainer()->make(TaskManagerContract::class),
            ));
        }

        $this->getContainer()->singleton(Config::class, function () use ($config) {
            return $config;
        });
    }
    
    /**
     * @return string
     */
    protected function configPath(): string
    {
        return __DIR__  . '/../../Config/abrouter.php';
    }
    
    /**
     * Gets Illuminate Container.
     *
     * @return Application|Container
     */
    protected function getContainer()
    {
        if ($this->app instanceof Container) {
            return $this->app;
        }
        
        if (function_exists('app')) {
            $app = app();
            
            if ($app instanceof Container) {
                $this->app = $app;
                
                return $app;
            }
        }
        
        throw new RuntimeException('Unable to locate Illuminate Container');
    }
    
    /**
     * @return string
     */
    private function getApplicationConfigPath(): string
    {
        return $this->app->configPath('abrouter.php');
    }

    private function configureKvStorage(): bool
    {
        $kvStorage = $this->getConfig()->get('abrouter.kvStorage');
        if (empty($kvStorage)) {
            return false;
        }

        $this->getContainer()->singleton(KvStorageContract::class, function () use ($kvStorage) {
            return $this->getContainer()->make($kvStorage);
        });

        return true;
    }

    private function isParallelRunningEnabled(): bool
    {
        $parallelRunningConfig = $this->getConfig()->get('abrouter.parallelRunning');

        if (!is_array($parallelRunningConfig)) {
            return false;
        }

        if (!isset($parallelRunningConfig['enabled'])) {
            return false;
        }

        if (empty($parallelRunningConfig['taskManager'])) {
            return false;
        }

        return (bool) $parallelRunningConfig['enabled'];
    }

    private function configureParallelRunning(): void
    {
        $taskManager = $this->getConfig()->get('abrouter.parallelRunning.taskManager');
        if (empty($taskManager)) {
            throw new RuntimeException('TaskManager class is not configured');
        }

        $this->getContainer()->singleton(TaskManagerContract::class, function () use ($taskManager) {
            return $this->getContainer()->make($taskManager);
        });
        $this->getContainer()->register(EventServiceProvider::class);
    }

    private function getConfig(): Repository
    {
        /**
         * @var Repository $configRepository
         */
        $configRepository = $this->getContainer()->make(Repository::class);
        return $configRepository;
    }
}
