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
        $this->withExceptionHandling();

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /**
     * Testa se o usuário convidado pode ver a página de criação
     * de threads.
     *
     * @test
     */
    public function test_guest_cannot_see_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /**
     * Testa se um usuário pode criar um thread e vê-lo.
     *
     * @test
     */
    public function test_an_authenticated_user_can_create_a_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->tittle)
            ->assertSee($thread->body);
    }
}
