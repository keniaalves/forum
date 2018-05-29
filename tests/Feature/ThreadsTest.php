<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Lança exceções
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * Listagem de Threads
     * @test
     * */
    public function testSeeAllThreads()
    {
        $thread   = factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSee($thread->title);
    }

    /**
     * Visualização de Thread específico
     *
     * @test
     */
    public function testReadASingleThread()
    {
        $thread   = factory('App\Thread')->create();
        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }
}
