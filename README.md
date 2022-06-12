# ABRouter Laravel A/B Tests | Split Tests

ABRouter AB Test :construction_worker_woman: is a simple package for base library to run A/B tests via [ABRouter (open-source)](https://abrouter.com) with Laravel.
You can find base PHP library in https://github.com/abrouter/abrouter-php-client

You're welcome to [visit the docs](https://docs.abrouter.com/docs/intro/).

# What is the ABRouter service ? 

[ABRouter](https://abrouter.com) is the open-source product to manage experiments(A/B split tests). The service provides easy to manage dashboard to keep experiments under control.
You can create experiments, branches and set up a percentage for every branch. Then, when you're running an ab-test on PHP you will receive a perfect branch-wise response that following the rules, that you set up.

Providing feature flags(feature toggles)
Available for free and open-source. 

You can find the ABRouter product source code by the following link: https://github.com/abrouter/compose

## Features

🛠 A/B Tests

🛠 Feature flags

🛠 Built-in statistics

🛠 Incredible UI to manage it 

🛠 Parallel running (non-blocking A/B tests running)


## Prepare your first A/B test
Besides of the installing this package you need to have an account on [ABRouter](https://abrouter.com). Your token and experiment id will be also there.
Feel free to read step by step instruction [Impelementing A/B tests on Laravel](https://abrouter.com/en/laravel-ab-tests)

## :package: Install
Via composer

``` bash
$ composer require abrouter/laravel-abtest
```

## Setting service provider
This package provide auto discovery for service provider

If Laravel package auto-discovery is disabled, add service providers manually to /config/app.php. There are service provider you must add:

```
\Abrouter\LaravelClient\Providers\AbrouterServiceProvider::class
```

### Publish client configuration:

```bash
php artisan vendor:publish --tag=abrouter
```

### Configure ABRouter client:

Put your ABRouter token in /config/abrouter.php. You can find this token in [ABRouter dashboard](https://abrouter.com/en/board).

```php

use Abrouter\LaravelClient\Bridge\KvStorage;
use Abrouter\LaravelClient\Bridge\ParallelRunning\TaskManager;

return [
    'token' => '14da89de1713a74c1ed50aafaff18c24bf372a9913e67e6a7a915def3332a97c9c9ecbe2cd6d3047',
    'host' => 'https://abrouter.com',
    'parallelRunning' => [
        'enabled' => true, //parallel running, enabled by default. See next section.
        'taskManager' => TaskManager::class,
    ],
    'kvStorage' => KvStorage::class
];
```

### Configure Parallel running

Parallel running is a feature that allows you to run A/B tests asynchronously. 
It requires ready-to-use Laravel cache (probably by Redis). 

This feature enables caching of experiment branches to run the experiment locally, then using Laravel built-in queues to sync the data with ABRouter server.
Please make sure, your supervisor config, queues and caching storage is enabled in Laravel to use.

Parallel running allows to run your A/B tests without blocking. 
Additionally, you can configure it on your own.

## :rocket: Usage

```php
use Abrouter\Client\Client;

class ExampleController
{
    public function __invoke(Client $client)
    {
        $buttonColor = $client->experiments()->run(uniqid(), 'D1D06000-0000-0000-00005030');
        return view('button', [
            'color' => $buttonColor->getBranchId(),
        ]);
    }
}
```

You can create an experiment and get your token and id of experiment on [ABRouter](https://abrouter.com) or just read the [docs](https://abrouter.com/en/docs). 


## Example
You can get an dockerized usage example by the following link: (https://github.com/abrouter/laravel-example)

## :wrench: Contributing

Please feel free to fork and sending Pull Requests. This project follows [Semantic Versioning 2](http://semver.org) and [PSR-2](http://www.php-fig.org/psr/psr-2/).

## :page_facing_up: License

GPL3. Please see [License File](LICENSE) for more information.
