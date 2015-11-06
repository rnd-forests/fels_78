<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\CapturesActivity;

class Relationship extends Model
{
    use CapturesActivity;

    protected $table = 'follows';
    protected $fillable = ['follower_id', 'followed_id'];

    protected static $activityUserId = 'follower_id';
    protected static $activityTargetId = 'followed_id';
    protected static $activityTargetType = User::class;
    protected static $capturedEvents = ['created', 'deleted'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
