<?php

namespace FELS\Entities\Traits;

use FELS\Entities\Activity;

trait CapturesActivity
{
    /**
     * Listen for events on model and capture the
     * appropriate activities.
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
     * @return \FELS\Entities\Activity
     */
    public function captureActivity($event)
    {
        $attributes = fetch_static_attributes(static::class, static::mapAttributes());
        list($userId, $targetId, $targetType) = $attributes;
        Activity::create([
            'user_id' => $this->$userId,
            'targetable_id' => $this->$targetId,
            'targetable_type' => $targetType,
            'action' => $this->getActivityName($this, $event),
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
     * Default events are: created, updated, and deleted.
     *
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$capturedEvents)) {
            return static::$capturedEvents;
        }

        return ['created', 'updated', 'deleted'];
    }

    /**
     * Get activity attributes mapping.
     *
     * @return array
     */
    protected static function mapAttributes()
    {
        return [
            'activityUserId' => 'user_id',
            'activityTargetId' => 'id',
            'activityTargetType' => static::class,
        ];
    }
}
