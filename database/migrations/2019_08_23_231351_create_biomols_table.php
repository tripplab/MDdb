<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBiomolsTable.
 */
class CreateBiomolsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('biomols', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('md_id')->index();
            $table->string('name');
            $table->string('chemical');
            $table->integer('n');
            $table->boolean('is_protein')->default(false);
            $table->boolean('is_dna')->default(false);
            $table->boolean('is_rna')->default(false);
            $table->boolean('is_lipid')->default(false);
            $table->boolean('is_carbohydrate')->default(false);
            $table->boolean('is_natural_product')->default(false);

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
		Schema::drop('biomols');
	}
}
