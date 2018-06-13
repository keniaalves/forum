<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
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

    public function test_a_user_can_filter_threads_according_to_a_tag()
    {
        $channel = create('App\Channel');

        $threadInChannel = factory('App\Thread')
            ->create(['channel_id' => $channel->id]);

        // $threadNotInChannel = factory('App\Thread')
        // ->create(['channel_id' => 2]);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($this->thread->title);
    }
}
