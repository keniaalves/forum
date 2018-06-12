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
        $this->withoutExceptionHandling();

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * Testa listagem de Threads
     * @test
     * */
    public function a_user_can_view_all_threads()
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
    public function a_user_can_read_a_single_thread()
    {
        $this->get('/threads/' . $this->thread->id)
            ->assertSee($this->thread->title);
    }

    /**
     * Testa se um usuário pode ver respostas associadas a um thread.
     *
     * @test
     */
    public function testReadThreadReplies()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get('/threads/' . $this->thread->id)
            ->assertSee($reply->body);
    }
}
