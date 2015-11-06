<?php

namespace FELS\Entities\Traits;

use FELS\Entities\Activity;

trait FlushRelatedActivities
{
    /**
     * Delete activities containing the model instance after
     * deleting that model instance.
     *
     * @return void
     */
    protected static function bootFlushRelatedActivities()
    {
        static::deleted(function ($model) {
            $model->clearInvalidActivities();
        });
    }

    /**
     * Clear activities with null target object.
     *
     * @return void
     */
    public static function clearInvalidActivities()
    {
        Activity::all()->filter(function ($activity) {
            return is_null($activity->targetable);
        })->each(function ($activity) {
            $activity->delete();
        });
    }
}
