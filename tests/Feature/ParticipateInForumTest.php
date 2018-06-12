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
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }

    /**
     * Dado um usuário autenticado e uma thread,
     * quando o usuário adicionar uma resposta para a thread, sua resposta deve ser visível na página
     *
     * @test
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply  = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
