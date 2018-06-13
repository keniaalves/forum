<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Usuário não autenticado não pode responder no fórum.
     *
     * @test
     */
    public function test_unauthenticated_user_may_not_add_in_forum_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * Dado um usuário autenticado e uma thread,
     * quando o usuário adicionar uma resposta para a thread, sua resposta deve ser visível na página
     *
     * @test
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create('App\User'));

        $thread = create('App\Thread');
        $reply  = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
/**
 * Testa se um usuário logado consegue fazer um post
 * de replies com dados inválidos.
 *
 * @return void
 */
    public function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply  = make('App\Reply', ['body'=>null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
