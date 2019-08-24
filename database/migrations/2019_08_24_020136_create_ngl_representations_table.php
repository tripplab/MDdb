<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateNglRepresentationsTable.
 */
class CreateNglRepresentationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ngl_representations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ngl_id')->index();
            $table->jsonb('representation');
            $table->jsonb('selection_keyword');
            $table->string('selection_expression');
            $table->jsonb('colour_scheme');
            $table->string('colour_selection');
            $table->float('scale');
            $table->float('opacity');
            $table->boolean('visible');
            $table->string('rep_options');
            $table->boolean('use_worker');

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
		Schema::drop('ngl_representations');
	}
}
