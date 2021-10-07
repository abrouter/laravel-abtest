# AbrPHPClient

AbrPHPClient :construction_worker_woman: is a PHP library to run ab-tests via ABRouter.

# What is the ABRouter service ? 

[ABRouter](https://abrouter.com) is the service to manage experiments(ab-tests). The service provides easy to manage dashboard to get experiments under control.
There you can create experiments, branches and set a percentage for every branch. Then, when you're running an ab-test on PHP you will receive a perfect branch-wise response that following the rules, that you set up.

Can be also used as a feature flag or feature toggle.
Available for free. 

## :package: Install
Via composer

``` bash
$ composer require abrouter/abrouter-php-client
```

## :rocket: Usage

Client is uses [PHP-DI](https://github.com/PHP-DI/PHP-DI) for DI. If you're uses own DI, you must to configure it in a such way as on example below. 
If you're not uses any DI, let's move php-di from dev-dependency to dependency:
``` bash
$ composer require "php-di/php-di": "^6.0"
```

### Using with PHP-DI

```php
use Abrouter\Client\Config\Config;
use DI\ContainerBuilder;
use Abrouter\Client\Client;

require '/app/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$di = $containerBuilder->build();

$token = 'Bearer Your Token';

$di->set(Config::class, new Config($token, 'https://abrouter.com'));
/**
 * @var Client $client
 */
$client = $di->make(Abrouter\Client\Client::class);
$userSignature = uniqid();
$experimentId = 'B2341200-0000-0000-00342340';


$runExperimentResult = $client->experiments()->run($userSignature, $experimentId);
$experimentId = $runExperimentResult->getExperimentId(); //form-color
$branchId = $runExperimentResult->getBranchId(); //red
echo '<button style="color: '. $branchId .'"></button>';
```

You can create an experiment and get your token and id of experiment on [ABRouter](https://abrouter.com) or just read the [docs](https://abrouter.com/en/docs). 

## :white_check_mark: Testing
Requires docker-compose and docker installed.

``` bash
$ make up
$ make test-run
```

## :wrench: Contributing

Please feel free to fork and sending Pull Requests. This project follows [Semantic Versioning 2](http://semver.org) and [PSR-2](http://www.php-fig.org/psr/psr-2/).

## :page_facing_up: License

GPL3. Please see [License File](LICENSE) for more information.
