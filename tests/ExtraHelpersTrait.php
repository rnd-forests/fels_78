<?php

trait ExtraHelpersTrait
{
    /**
     * Mocking a class helper.
     *
     * @param $class
     *
     * @return \Mockery\MockInterface
     */
    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Set the current authenticated user instance.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function setAuthUser(array $attributes = [])
    {
        $user = factory(FELS\Entities\User::class)->create($attributes);
        $this->actingAs($user);

        return $user;
    }
}
