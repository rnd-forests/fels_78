<?php

trait ExtraAssertionsTrait
{
    /**
     * Assert the view name.
     *
     * @param $name
     */
    public function assertViewIs($name)
    {
        $this->assertEquals($name, $this->response->original->getName());
    }
}
