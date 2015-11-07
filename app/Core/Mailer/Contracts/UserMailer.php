<?php

namespace FELS\Core\Mailer\Contracts;

interface UserMailer
{
    /**
     * Send email with account activation link.
     *
     * @param $user
     * @param $code
     * @return mixed
     */
    public function sendActivationURL($user, $code);
}
