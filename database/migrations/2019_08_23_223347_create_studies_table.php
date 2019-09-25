<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateStudiesTable.
 */
class CreateStudiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('studies', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('short_title');
            $table->string('abstract');
            $table->binary('pipe_config');

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
		Schema::drop('studies');
	}
}
