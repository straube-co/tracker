<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserHasMultiplePermission()
    {
        $user = factory(User::class)->make();
        $user->access = 3;
        $this->assertEquals([ 1, 2 ], $user->access());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserHasNoPermission()
    {
        $user = factory(User::class)->make();
        $user->access = 0;
        $this->assertEquals([], $user->access());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserHasOnePermission()
    {
        $user = factory(User::class)->make();
        $user->access = 4;
        $this->assertEquals([ 4 ], $user->access());
    }
}
