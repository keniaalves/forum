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
     * Testa se, quando o usuário acessa uma rota de listagem de threads filtrando
     * pelo channel, ele consegue ver somente os threads daquele channel e não outros.
     *
     * @return void
     */
    public function test_empresa_requer_endereco()
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

    /**
     * Testa se ao filtrar threads pela popularidade somente
     * retornará o thread com maior número de replies.
     *
     * @test
     */
    public function test_a_user_can_filter_threads_by_popularity()
    {
        //padrão do $this->thread é zero replies

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
      $thread = create('App\Thread');

      create('App\Reply', ['thread_id' => $thread->id]);

      $response = $this->getJson('threads?unanswered=1')->json();

      $this->assertCount(1, $response);
    }

    /**@test*/
    public function test_a_user_can_request_all_replies_for_a_given_thread()
    {
      $thread = create('App\Thread');

      create('App\Reply', ['thread_id' => $thread->id], 2);

      $response = $this->getJson($thread->path() . '/replies')->json();

      // dd($response);

      $this->assertCount(2, $response['data']);
      $this->assertEquals(2, $response['total']);
    }
}
