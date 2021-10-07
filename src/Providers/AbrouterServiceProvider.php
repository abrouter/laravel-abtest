<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient;

use Abrouter\Client\Config\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use RuntimeException;
use Illuminate\Config\Repository;

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
        /**
         * @var Repository $configRepository
         */
        $configRepository = $this->getContainer()->make(Repository::class);
        
        $this->getContainer()->singleton(Config::class, function () use ($configRepository) {
            return new Config(
                (string) $configRepository->get('abrouter.token'),
                (string) $configRepository->get('abrouter.host')
            );
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
}
