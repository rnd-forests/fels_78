<?php

namespace FELS\Core\Repository\Contracts\Activity;

interface CanBeUpdated
{
    /**
     * Update a model instance.
     *
     * @param array $data
     * @param $identifier
     * @param null $optionalIdentifier
     * @return bool|int
     */
    public function update(array $data, $identifier, $optionalIdentifier = null);
}
