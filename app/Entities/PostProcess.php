<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PostProcess.
 *
 * @package namespace App\Entities;
 */
class PostProcess extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $table = 'post_process';

    public function studies()
    {
        $related = $this->belongsTo('App\Entities\Study');

        return $related;
    }

}
