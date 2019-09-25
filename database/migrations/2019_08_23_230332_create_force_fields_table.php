<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateForceFieldsTable.
 */
class CreateForceFieldsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('force_fields', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ver');
            $table->string('url');

            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('force_fields');
	}
}
