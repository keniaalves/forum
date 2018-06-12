<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /**
     * Testa se o thread deveria ter resposta. Testa a relação.
     * @test
     */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * Testa se o thread deveria ter dono. Testa a relação.
     * @test
     */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /**
     * Testa se uma thread pode adicionar uma reply.
     *
     * @return void
     */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'   => 'Foobar',
            'user_id'=> 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
