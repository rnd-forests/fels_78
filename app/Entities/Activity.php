<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';
    protected $fillable = ['user_id', 'targetable_id', 'targetable_type', 'action'];

    /**
     * The user who generated the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the target object associated with the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function targetable()
    {
        return $this->morphTo();
    }
}
