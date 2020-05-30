<?php

namespace Tests;

use Slim\App;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /** @var App|null */
    protected $app;

    /**
     * @var Factory
     */
    protected $faker;

    protected function setUp(): void
    {
        $this->app = require __DIR__ . '/../tests/bootstrap.php';
        $this->faker = Factory::create();
    }

    /**
     * @return App|null
     */
    public function getApp(): ?App
    {
        return $this->app;
    }
}