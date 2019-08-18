<?php

use Illuminate\Database\Seeder;
use App\Entities\MolecularDynamic;
use Webpatser\Uuid\Uuid;

class MolecularDynamics extends Seeder
{
    private $repository;
    private $records = [
        [
            'uuid' => '5d618fe6-c111-43da-be3d-2d6c416b39fe',
            'name' => 'S1: lido',
            'description' => '',
            'positions' => [
                'x' => '2.51',
                'y' => '2.51',
                'z' => '2.51',
            ],
            'ns' => 1000,
            'data' => [
                'lido' => 1,
                'bupi' => 0,
                'dppc' => 0,
                'water' => 485,
                'na' => 7,
                'cl' => 8,
                't_k' => 310,
                'day_cpu' => 90.37,
            ],
        ],
        [
            'name' => 'S2: bupi',
            'description' => '',
            'positions' => [
                'x' => '2.53',
                'y' => '2.53',
                'z' => '2.53'
            ],
            'ns' => 1000,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S3: dppc (bilayer)',
            'description' => '',
            'positions' => [
                'x' => '4.47',
                'y' => '4.01',
                'z' => '10.75'
            ],
            'ns' => 1000,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S4: dppc+lido (bilayer)',
            'description' => '',
            'positions' => [
                'x' => '4.50',
                'y' => '4.03',
                'z'=> '10.62'
            ],
            'ns' => 1000,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S5: dppc+bupi (bilayer)',
            'description' => '',
            'positions' => [
                'x' => '4.48',
                'y' => '4.02',
                'z' => '10.56'
            ],
            'ns' => 100,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S6: dppc (monolayer)',
            'description' => '',
            'positions' => [
                'x' => '4.60',
                'y' => '4.12',
                'z' => '20.16'
            ],
            'ns' => 500,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S7: dppc+lido (monolayer)',
            'description' => '',
            'positions' => [
                'x' => '4.60',
                'y' => '4.12',
                'z' => '20.16'
            ],
            'ns' => 500,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
        [
            'name' => 'S8: dppc+bupi (monolayer)',
            'description' => '',
            'positions' => [
                'x' => '4.60',
                'y' => '4.12',
                'z' => '20.16'
            ],
            'ns' => 500,
            'data' => [
                'lido' => null,
                'bupi' => null,
                'dppc' => null,
                'water' => null,
                'na' => null,
                'cl' => null,
                't_k' => null,
                'day_cpu' => null,
            ],
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->records as $record) {
            $model = new MolecularDynamic($record);
            $model->uuid = Uuid::generate()->string;
            $model->positions = json_encode($model->positions);
            $model->data = json_encode($model->data);
            $model->save();
        }
    }
}
