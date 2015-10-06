<?php

namespace FELS\Entities\Presenters\Traits;

use FELS\Exceptions\PresenterException;

trait PresentableTrait
{
    protected $instance;

    /**
     * Prepare a new or retrieve old presenter instance (singleton).
     *
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (!$this->presenter || !class_exists($this->presenter)) {
            throw new PresenterException(trans('presenter.presenter_exception'));
        }
        if (!$this->instance) {
            $this->instance = new $this->presenter($this);
        }

        return $this->instance;
    }
}
