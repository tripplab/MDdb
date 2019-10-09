<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Study.
 *
 * @package namespace App\Entities;
 */
class Study extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $table = 'study';

    public function authors()
    {
        $related = $this->belongsToMany(
            'App\Entities\Author', 'sa', 'study_id', 'author_id'
        );

        return$related;
    }

    public function coauthors()
    {
        $related = $this->hasMany('App\Entities\Coauthors', 'study_id');

        return $related;
    }

    public function ipViews()
    {
        $related = $this->belongsToMany(
            'App\Entities\Ip', 'views', 'study_id', 'ip_id'
        );

        return$related;
    }

    public function published()
    {
        $related = $this->hasOne('App\Entities\Published', 'study_id');

        return $related;
    }

}
