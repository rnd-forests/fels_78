<?php

namespace FELS\Listeners;

use FELS\Events\UserHasRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use FELS\Core\Mailer\Contracts\UserMailerInterface;

class UserEventListener
{
    protected $mailer;

    /**
     * Constructor.
     *
     * @param $mailer
     */
    public function __construct(UserMailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handler user registration event.
     *
     * @param UserHasRegistered $event
     */
    public function onUserRegister(UserHasRegistered $event)
    {
        $this->mailer->emailActivationLink(
            $event->user,
            $event->user->confirmation_code
        );
    }

    /**
     * Subscribe all user events.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            \FELS\Events\UserHasRegistered::class,
            'FELS\Listeners\UserEventListener@onUserRegister'
        );
    }
}
