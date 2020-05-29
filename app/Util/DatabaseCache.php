<?php

namespace App\Util;

use Closure;
use Exception;
use App\Entities\Cache;
use Psr\SimpleCache\CacheInterface;
use App\Exceptions\InvalidKeyArgumentException;

/**
 * Class DatabaseCache
 * @package App\Util
 */
class DatabaseCache implements CacheInterface
{

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     * @throws InvalidKeyArgumentException
     */
    public function get($key, $default = null)
    {
        $this->validateKey($key);
        $value = Cache::whereKey($key)->first();

        if ($value === null) {
            return $default;
        }

        return $value->value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return Cache
     * @throws InvalidKeyArgumentException
     */
    public function set($key, $value, $ttl = null)
    {
        $this->validateKey($key);

        Cache::whereKey($key)->delete();

        return Cache::create([
            'key' => $key,
            'value' => $value
        ]);
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidKeyArgumentException
     */
    public function delete($key): bool
    {
        $this->validateKey($key);

        return Cache::whereKey($key)->delete();
    }

    /**
     * @return bool|null
     * @throws Exception
     */
    public function clear()
    {
        return Cache::query()->delete() > 0;
    }


    /**
     * @param iterable $keys
     * @param null $default
     * @return array|iterable
     * @throws InvalidKeyArgumentException
     */
    public function getMultiple($keys, $default = null)
    {
        $data = [];
        foreach ($keys as $key) {
            $value = $this->get($key);
            if ($value !== null) {
                $data[$key] = $value;
                continue;
            }

            $data[$key] = $default;
        }

        return $data;
    }

    /**
     * @param iterable $values
     * @param null $ttl
     * @return bool|void
     * @throws InvalidKeyArgumentException
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($value, $key);
        }
    }

    /**
     * @param iterable $keys
     * @return bool|void
     * @throws InvalidKeyArgumentException
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidKeyArgumentException
     */
    public function has($key): bool
    {
        $this->validateKey($key);

        $value = Cache::whereKey($key)->first();

        return $value === null;
    }

    /**
     * @param string $key
     * @throws InvalidKeyArgumentException
     */
    private function validateKey(string $key)
    {
        if (strlen($key) > 255) {
            throw new InvalidKeyArgumentException('The key may not be greater than 255 characters');
        }
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param $key
     * @param Closure $callback
     * @return mixed
     * @throws InvalidKeyArgumentException
     */
    public function remember($key, Closure $callback)
    {
        $value = $this->get($key);

        if ($value !== null) {
            return json_decode($value);
        }

        $value = $callback();


        $this->set($key, json_encode($value));

        return $value;
    }
}