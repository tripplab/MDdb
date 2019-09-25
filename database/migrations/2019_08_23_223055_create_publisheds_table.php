<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePublishedsTable.
 */
class CreatePublishedsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisheds', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('study_id')->index();
            $table->string('doi_preprint');
            $table->string('doi_paper');

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
		Schema::drop('publisheds');
	}
}
