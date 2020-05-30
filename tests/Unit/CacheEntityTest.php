<?php

namespace Tests\Unit;

use Tests\BaseTestCase;
use App\Entities\Cache;
use Tests\DatabaseTestTrait;

/**
 * @group CacheEntity
 * Class CacheEntityTest
 * @package Tests\Unit
 */
class CacheEntityTest extends BaseTestCase
{
    use DatabaseTestTrait;

    public function testShouldCreateCache(): void
    {
        $key = $this->faker->word();
        Cache::create([
            'key' => $key,
            'value' => json_encode($this->faker->words(3, false))
        ]);

        $cache = Cache::whereKey($key)->first();

        $this->assertNotNull($cache);
    }

    public function testShouldFindCache(): void
    {
        $key = $this->faker->word();
        $value = json_encode($this->faker->words(3, false));
        $cache = Cache::create([
            'key' => $key,
            'value' => $value
        ]);

        $this->assertJson($value, $cache->value);
    }

    public function testShouldDeleteCache(): void
    {
        $key = $this->faker->word();

        Cache::create([
            'key' => $key,
            'value' => json_encode($this->faker->words(3, false))
        ]);

        Cache::whereKey($key)->delete();

        $cache = Cache::whereKey($key)->first();

        $this->assertNull($cache);
    }

    public function testShouldUpdateCache(): void
    {
        $key = $this->faker->word();
        Cache::create([
            'key' => $key,
            'value' => json_encode($this->faker->words(3, false))
        ]);

        $newValue = json_encode($this->faker->words(3, false));

        Cache::whereKey($key)->update([
            'value' => $newValue
        ]);

        $cache = Cache::whereKey($key)->first();

        $this->assertJson($newValue, $cache->value);
    }

}