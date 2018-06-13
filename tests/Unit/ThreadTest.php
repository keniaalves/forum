<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    /**
     * Lança exceções, fornece as threads.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_can_make_a_string_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }

    /**
     * Testa se o thread deveria ter resposta. Testa a relação.
     * @test
     */
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * Testa se o thread deveria ter dono. Testa a relação.
     * @test
     */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /**
     * Testa se uma thread pode adicionar uma reply.
     * Testa a relação no model.
     *
     * @return void
     */
    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'   => 'Foobar',
            'user_id'=> 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function a_thread_belongs_to_a_channel()
    {
        $this->thread->assertInstanceOf('App\Channel', $this->thread->channel);
    }
}
