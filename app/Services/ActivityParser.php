<?php

namespace FELS\Services;

class ActivityParser
{
    /**
     * The user who triggers the activity.
     *
     * @param $activity
     * @return \FELS\Entities\User
     */
    public function owner($activity)
    {
        return $activity->user;
    }

    /**
     * Diff-time of the activity.
     *
     * @param $activity
     * @return string
     */
    public function timeAgo($activity)
    {
        return humans_time($activity->created_at);
    }

    /**
     * The target object associated with the activity.
     *
     * @param $activity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function target($activity)
    {
        return $activity->targetable;
    }

    /**
     * Get the url to target object.
     *
     * @param $activity
     * @return string
     */
    public function url($activity)
    {
        return $this->target($activity)->url;
    }
}
