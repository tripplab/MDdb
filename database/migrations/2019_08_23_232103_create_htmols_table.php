<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateHtmolsTable.
 */
class CreateHtmolsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('htmols', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('md_id')->index();
            $table->boolean('autoplay')->default(false);
            $table->string('representation');
            $table->float('radius');
            $table->integer('sphere_resolution');
            $table->boolean('show_axis')->default(false);
            $table->string('commands');
            $table->integer('line_width');
            $table->float('light_power');
            $table->integer('max_size');
            $table->integer('n_paso');
            $table->boolean('show_open')->default(false);
            $table->boolean('show_download')->default(false);
            $table->string('comment');

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
		Schema::drop('htmols');
	}
}
