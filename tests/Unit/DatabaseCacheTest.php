<?php


namespace Tests\Unit;


use Tests\BaseTestCase;
use App\Util\DatabaseCache;
use Tests\DatabaseTestTrait;

/**
 * @group DatabaseCache
 * Class DatabaseCacheTest
 * @package Tests\Unit
 */
class DatabaseCacheTest extends BaseTestCase
{
    use DatabaseTestTrait;

    public function testShouldSaveDatabaseCache(): void
    {
        $key = $this->faker->word();
        $value = json_encode($this->faker->words(3, false));

        $databaseCache = new DatabaseCache();
        $databaseCache->set($key, $value);

        $this->assertJson($value, $databaseCache->get($key));
    }

    public function testShouldHasKey(): void
    {
        $key = $this->faker->word();
        $value = json_encode($this->faker->words(3, false));

        $databaseCache = new DatabaseCache();
        $databaseCache->set($key, $value);

        $this->assertTrue($databaseCache->has($key));
    }

    public function testShouldDeleteDatabaseCache(): void
    {
        $key = $this->faker->word();
        $value = json_encode($this->faker->words(3, false));

        $databaseCache = new DatabaseCache();
        $databaseCache->set($key, $value);

        $this->assertTrue($databaseCache->delete($key));
    }

    public function testShouldClearDatabaseCache(): void
    {
        $key = $this->faker->word();
        $value = json_encode($this->faker->words(3, false));

        $databaseCache = new DatabaseCache();
        $databaseCache->set($key, $value);

        $this->assertTrue($databaseCache->clear());
    }

    public function testShouldGetMultipleDatabaseCache(): void
    {
        $keys = [];
        for ($i = 0; $i < $this->faker->randomDigit; $i++) {
            $key = $this->faker->word();
            $value = json_encode($this->faker->words(3, false));

            $databaseCache = new DatabaseCache();
            $databaseCache->set($key, $value);

            $keys[] = $key;
        }

        $databaseCache = new DatabaseCache();
        $data = $databaseCache->getMultiple($keys);

        $this->assertSameSize($keys, $data);
    }

    public function testShouldSetMultipleDatabaseCache(): void
    {
        $keys = [];
        for ($i = 0; $i < $this->faker->randomDigit; $i++) {
            $key = $this->faker->word();
            $value = json_encode($this->faker->words(3, false));

            $keys[$key] = $value;
        }

        $databaseCache = new DatabaseCache();

        $this->assertTrue($databaseCache->setMultiple($keys));
    }

    public function testShouldDeleteMultipleDatabaseCache(): void
    {
        $keys = [];
        for ($i = 0; $i < $this->faker->randomDigit; $i++) {
            $key = $this->faker->word();
            $value = json_encode($this->faker->words(3, false));

            $keys[$key] = $value;
        }

        $databaseCache = new DatabaseCache();
        $databaseCache->setMultiple($keys);

        $this->assertTrue($databaseCache->deleteMultiple(array_keys($keys)));
    }
}