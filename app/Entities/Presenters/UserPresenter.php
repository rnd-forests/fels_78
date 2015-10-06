<?php

namespace FELS\Entities\Presenters;

class UserPresenter extends AbstractPresenter
{
    /**
     * Get gravatar profile image associated with user's email address.
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size = 35)
    {
        return trans('presenter.gravatar', [
            'email' => md5($this->email), 'size' => $size
        ]);
    }
}
