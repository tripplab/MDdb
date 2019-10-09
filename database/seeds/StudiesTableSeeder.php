<?php

use Illuminate\Database\Seeder;

class StudiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\Entities\Study::class, 500)->create()->each(function ($study) {
            $study->authors()->save(factory(App\Entities\Author::class)->make());
            $study->coauthors()->save(factory(App\Entities\Coauthors::class)->make());
            $study->ipViews()->save(factory(App\Entities\Ip::class)->make());
            $study->published()->save(factory(App\Entities\Published::class)->make());
        });;
    }
}
