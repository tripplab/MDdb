<?php

namespace App\Api\V1\Transformers;

use App\Models\Log;
use League\Fractal\TransformerAbstract;

class LogTransformer extends TransformerAbstract
{
    /**
     * List of resources to include by default.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'entries', 'tasks',
    ];

    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'entries', 'tasks',
    ];

    /**
     * Turn this item object into a generic array.
     *
     * @return array
     */
    public function transform(Log $log)
    {
        return [
            'log_id' => $log->id,
        ];
    }

    /**
     * Includes Entries data within Log object.
     *
     * @return collection|App\Models\Log
     */
    public function includeEntries(Log $log)
    {
        if ($log->entries->all() != []) {
            return $this->collection($log->entries, new EntryTransformer());
        }
    }

    /**
     * Includes Tasks data within Log object.
     *
     * @return collection|App\Models\Log
     */
    public function includeTasks(Log $log)
    {
        if ($log->tasks->all() != []) {
            return $this->collection($log->tasks, new TaskTransformer());
        }
    }
}
