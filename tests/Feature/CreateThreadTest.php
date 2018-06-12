<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Testa se usuário convidado pode criar threads.
     *
     * @test
     */
    public function test_guest_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());
    }

    /**
     * Testa se um usuário pode criar um thread e vê-lo.
     *
     * @test
     */
    public function test_an_authenticated_user_can_create_a_new_forum_threads()
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->tittle)
            ->assertSee($thread->body);
    }
}
