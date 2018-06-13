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

        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->tittle)
            ->assertSee($thread->body);
    }
}
