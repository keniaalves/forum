<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Testa se o usuário convidado, ao tentar acessar a página de
     * criação de threads e tentar enviar dados em um post para a
     * rota que salva uma thread, será redirecionado para a página de login.
     *
     * @test
     */
    public function test_guest_cannot_create_thread()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray())
                ->assertRedirect('/login');
    }

    /**
     * Testa se um usuário logado pode criar um thread e vê-lo.
     *
     * @test
     */
    public function test_an_authenticated_user_can_create_a_new_forum_threads()
    {
        $this->signIn();

        $thread   = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->tittle)
            ->assertSee($thread->body);
    }

    /**
     * Testam se um usuário logado consegue fazer um post
     * de threads com dados inválidos.
     *
     * @test
     */
    public function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {
        $channel = factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread   = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
