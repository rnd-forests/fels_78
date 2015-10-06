<?php

namespace FELS\Core\Mailer\Contracts;

interface UserMailerInterface
{
    /**
     * Send an email with account activation link to user.
     *
     * @param $user
     * @param $code
     * @return mixed
     */
    public function emailActivationLink($user, $code);
}
