<?php

namespace FELS\Entities\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    /**
     * Get gravatar profile image associated
     * with user's email address.
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size = 35)
    {
        return trans('presenter.gravatar', ['email' => md5($this->email), 'size' => $size]);
    }

    /**
     * Link to user GitHub profile.
     *
     * @return string
     */
    public function githubUrl()
    {
        return trans('presenter.github', ['name' => $this->github_name]);
    }

    /**
     * Link to user Google Plus profile.
     *
     * @return string
     */
    public function googleUrl()
    {
        return trans('presenter.google', ['name' => $this->google_name]);
    }

    /**
     * Link to user Facebook profile.
     *
     * @return string
     */
    public function facebookUrl()
    {
        return trans('presenter.facebook', ['name' => $this->facebook_name]);
    }
}
