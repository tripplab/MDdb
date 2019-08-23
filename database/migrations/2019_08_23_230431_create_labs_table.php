<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLabsTable.
 */
class CreateLabsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('labs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->string('department');
            $table->integer('institution_id')->index();

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
		Schema::drop('labs');
	}
}
