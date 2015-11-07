<?php

namespace FELS\Core\OAuth\Contracts;

interface Extractable
{
    /**
     * Extract and update user from data
     * returned from provider.
     *
     * @param $user
     * @param $data
     * @return bool|int
     */
    public function extractAndUpdate($user, $data);
}
