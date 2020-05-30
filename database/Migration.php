<?php

namespace Migrations;

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Migration
 * @package Migrations
 */
class Migration extends AbstractMigration
{
    /** @var Capsule $capsule */
    public $capsule;
    /** @var Builder $capsule */
    public $schema;

    /**
     *
     */
    public function init()
    {
        $database = include(__DIR__ . '/../config/database.php');
        $database = $database[$_ENV['DB_DRIVER']];

        $this->capsule = new Capsule;
        $this->capsule->addConnection($database);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}