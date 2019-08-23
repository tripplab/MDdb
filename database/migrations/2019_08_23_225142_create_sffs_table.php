<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSffsTable.
 */
class CreateSffsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sffs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('study_id')->index();
            $table->integer('force_field_id')->index();

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
		Schema::drop('sffs');
	}
}
