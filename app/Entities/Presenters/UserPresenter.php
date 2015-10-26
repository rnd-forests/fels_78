<?php

namespace FELS\Entities\Presenters;

class UserPresenter extends AbstractPresenter
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
        return trans('presenter.gravatar', [
            'email' => md5($this->email), 'size' => $size
        ]);
    }

    /**
     * Link to user GitHub profile.
     *
     * @param $user
     * @return string
     */
    public function githubUrl($user)
    {
        return trans('presenter.github_url', [
            'name' => $user->github_name
        ]);
    }

    /**
     * Link to user Google Plus profile.
     *
     * @param $user
     * @return string
     */
    public function googleUrl($user)
    {
        return trans('presenter.google_url', [
            'name' => $user->google_name
        ]);
    }

    /**
     * Link to user Facebook profile.
     *
     * @param $user
     * @return string
     */
    public function facebookUrl($user)
    {
        return trans('presenter.facebook_url', [
            'name' => $user->facebook_name
        ]);
    }
}
