<?php

namespace Tests;

use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Integration test.
 */
trait DatabaseTestTrait
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->migrate();
    }

    /** {@inheritdoc} */
    protected function tearDown(): void
    {
        $this->rollback();
    }

    /**
     * Prepare the database schema with phinx (slow).
     *
     * @return bool Success
     */
    protected function migrate(): bool
    {
        $config = new Config(require __DIR__ . '/../config-phinx.php');
        $manager = new Manager($config, new StringInput(' '), new NullOutput());
        $manager->migrate('testing');

        return true;
    }

    protected function rollback()
    {
        $config = new Config(require __DIR__ . '/../config-phinx.php');
        $manager = new Manager($config, new StringInput(' '), new NullOutput());

        $manager->rollback('testing');
    }
}