<?php

namespace FELS\Entities\Traits;

use FELS\Entities\Activity;

trait CapturesActivity
{
    /**
     * Listen for events on model and capture the appropriate activities.
     * When booting model, the framework also boots included traits in
     * the model.
     *
     * @return void
     */
    protected static function bootCapturesActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->captureActivity($event);
            });
        }
    }

    /**
     * Capture the activity.
     *
     * @param $event
     */
    public function captureActivity($event)
    {
        $userId = option(static::$activityUserId, 'user_id');
        $targetId = option(static::$activityTargetId, 'id');
        $targetType = option(static::$activityTargetType, static::class);
        Activity::create([
            'user_id' => $this->$userId,
            'targetable_id' => $this->$targetId,
            'targetable_type' => $targetType,
            'action' => $this->getActivityName($this, $event)
        ]);
    }

    /**
     * Get the activity name.
     *
     * @param $model
     * @param $action
     * @return string
     */
    public function getActivityName($model, $action)
    {
        $name = strtolower(class_basename($model));

        return "{$action}_{$name}";
    }

    /**
     * Which events on the model should be captured?
     *
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$capturedEvents)) {
            return static::$capturedEvents;
        }

        return ['created', 'deleted', 'updated'];
    }
}
