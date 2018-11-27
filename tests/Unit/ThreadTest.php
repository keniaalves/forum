<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

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
     * @test
     */
    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'   => 'Foobar',
            'user_id'=> 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
    * @test
    */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
      Notification::fake();

      $this->signIn()
        ->thread
        ->subscribe()
        ->addReply([
          'body'   => 'Foobar',
          'user_id'=> 999
      ]);

      Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

  /**
  * @test
  */
    public function a_thread_can_be_subscribed_to()
    {
      $thread = create('App\Thread');

      $this->signIn();

      $thread->subscribe();

      $this->assertEquals(1,$thread->subscriptions()->where('user_id', auth()->id())->count());

    }

    /**
    * @test
    */
    public function a_thread_can_be_unsubscribed_from()
    {
      $thread = create('App\Thread');

      $thread->subscribe($userId = 1);

      $thread->unsubscribe($userId);

      $this->assertCount(0, $thread->subscriptions);
    }

    /**
    * @test
    */
    public function it_knows_if_this_authenticated_user_is_subscribed_to_it()
    {
      $thread = create('App\Thread');

      $this->signIn();

      $this->assertFalse($thread->isSubscribedTo);

      $thread->subscribe();

      $this->assertTrue($thread->isSubscribedTo);

    }
}
