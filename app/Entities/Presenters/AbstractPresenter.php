<?php

namespace FELS\Entities\Presenters;

abstract class AbstractPresenter
{
    protected $model;

    /**
     * Constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Check if the presenter method exists on the model instance,
     * and call it. Otherwise pass it to the original object.
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->model->{$property};
    }
}
