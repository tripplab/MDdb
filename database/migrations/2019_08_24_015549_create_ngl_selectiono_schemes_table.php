<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNglSelectionoSchemesTable.
 */
class CreateNglSelectionoSchemesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ngl_selectiono_schemes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ngl_id')->index();
            $table->string('alias');
            $table->string('name');
            $table->string('pairs');

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
		Schema::drop('ngl_selectiono_schemes');
	}
}
