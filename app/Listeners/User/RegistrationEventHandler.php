<?php

namespace FELS\Listeners\User;

use FELS\Events\UserHasRegistered;
use FELS\Core\Mailer\Contracts\UserMailer;

class RegistrationEventHandler
{
    protected $mailer;

    /**
     * Constructor.
     *
     * @param $mailer
     */
    public function __construct(UserMailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle successful registration event.
     *
     * @param UserHasRegistered $event
     */
    public function handle(UserHasRegistered $event)
    {
        $this->mailer->sendActivationURL($event->user, $event->user->confirmation_code);
    }
}
