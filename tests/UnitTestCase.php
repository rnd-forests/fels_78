<?php

class UnitTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Terminate the mockery.
     */
    public function tearDown()
    {
        Mockery::close();
    }
}
