<?php

namespace FELS\Events;

use FELS\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserHasRegistered extends Event
{
    use SerializesModels;

    public $user;

    /**
     * Constructor.
     *
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
