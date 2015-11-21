<?php

namespace FELS\Listeners\User;

use FELS\Events\UserHasRegistered;
use Illuminate\Contracts\Events\Dispatcher;

class UserEventSubscriber
{
    /**
     * Subscribe to user-related events.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserHasRegistered::class, RegistrationEventHandler::class);
    }
}
