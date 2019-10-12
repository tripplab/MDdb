<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SimulationProtocolAnalysis.
 *
 * @package namespace App\Entities;
 */
class SimulationProtocolAnalysis extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $table = 'simulation_protocol_analysis';

    public function studies()
    {
        $related = $this->belongsTo('App\Entities\Study');

        return $related;
    }

}
