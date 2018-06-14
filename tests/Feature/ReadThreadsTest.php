<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Lança exceções, fornece as threads.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /**
     * Testa listagem de Threads
     * @test
     * */
    public function test_a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertStatus(200);
        $response->assertSee($this->thread->title);
    }

    /**
     * Testa visualização de Thread específico
     *
     * @test
     */
    public function test_a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /**
     * Testa se um usuário pode ler respostas associadas a um thread.
     *
     * @test
     */
    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /**
     * Testa se, quando o usuário acessa uma rota de listagem de threads filtrando
     * pelo channel, ele consegue ver somente os threads daquele channel e não outros.
     *
     * @return void
     */
    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');

        $threadInChannel = factory('App\Thread')
            ->create(['channel_id' => $channel->id]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($this->thread->title);
    }

    /**
     * Pela url o usuário consegue acessar threads de usuários específicos e
     * pelo menu, tem acesso aos seus threads.
     *
     * Esse método testa se um usuário pode filtrar threads por qualquer
     * nome de usuário.
     *
     * @test
     */
    public function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'kenia']));
        $threadByKenia    = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByKenia = create('App\Thread');

        $this->get('threads?by=kenia')
            ->assertSee($threadByKenia->title)
            ->assertDontSee($threadNotByKenia->title);
    }
}