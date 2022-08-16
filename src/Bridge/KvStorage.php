<?php
declare(strict_types = 1);

namespace Abrouter\LaravelClient\Bridge;

use Abrouter\Client\Contracts\KvStorageContract;
use Illuminate\Support\Facades\Cache;

class KvStorage implements KvStorageContract
{
    public function put(string $key, string $value, int $expiresInSeconds = 0): void
    {
        Cache::store()->put($key, $value, $expiresInSeconds);
    }

    public function remove(string $key): void
    {
        Cache::store()->delete($key);
    }

    public function get(string $key)
    {
        return Cache::store()->get($key);
    }
}
