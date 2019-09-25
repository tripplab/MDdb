<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostProcessesTable.
 */
class CreatePostProcessesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_processes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('study_id')->index();
            $table->string('name');
            $table->string('command');

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
		Schema::drop('post_processes');
	}
}
