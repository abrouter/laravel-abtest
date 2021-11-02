# ABRouter Laravel A/B Tests | Split Tests

ABRouter Laravel Bridge :construction_worker_woman: is a simple bridge for base library to run ab-tests via ABRouter with Laravel.
You can find base PHP library in https://github.com/abrouter/abrouter-php-client

# What is the ABRouter service ? 

[ABRouter](https://abrouter.com) is the service to manage experiments(ab-tests). The service provides easy to manage dashboard to get experiments under control.
There you can create experiments, branches and set a percentage for every branch. Then, when you're running an ab-test on PHP you will receive a perfect branch-wise response that following the rules, that you set up.

Can be also used as a feature flag or feature toggle.
Available for free. 

## :package: Install
Via composer

``` bash
$ composer require abrouter/laravel-abtest
```

## Setting service provider
This package provide auto discovery for service provider

If Laravel package auto-discovery is disabled, add service providers manually. There are two service providers you must add:

```
\Abrouter\LaravelClient\Providers\AbrouterServiceProvider
```

### Publish client configuration:

```bash
php artisan vendor:publish --tag=abrouter
```


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
