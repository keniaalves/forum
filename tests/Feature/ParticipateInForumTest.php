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

    /**
     * @test
     */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn();
        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', [
            'user_id' => auth()->id()
        ]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);
    }

    /**
     * @test
     */
    public function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn();
        $this->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', [
            'user_id' => auth()->id()
        ]);
        $updatedReply = 'You been changed, fool.';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply])
            ->assertStatus(200);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
