<?php

namespace Tests\Unit;

use Tests\TestCase;

class ChannelTest extends TestCase
{
    /**
     * Testa se um channel possui threads.
     * Cria um thread e o associa a um channel.
     * Verifica se ao consultar o channel criado e
     * buscar suas threads, ele irá conter o thread criado.
     *
     * @test
     */
    public function test_a_channel_consists_of_threads()
    {
        $channel = create('App\Channel');
        $thread  = create('App\Thread', ['channel_id' =>$channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
