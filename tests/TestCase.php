<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create an user and login
     *
     * @return mixed
     */
    protected function login()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        return $user;
    }
}
