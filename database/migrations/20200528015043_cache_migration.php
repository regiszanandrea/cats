<?php

use Migrations\Migration;

/**
 * Class CacheMigration
 */
class CacheMigration extends Migration
{
    /**
     *
     */
    public function up()
    {
        $this->schema->create('cache', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('key');
            $table->json('value');

            $table->primary(['key']);
        });
    }

    /**
     *
     */
    public function down()
    {
        $this->schema->drop('widgets');
    }
}
