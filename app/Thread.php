<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    /**
     * Retorna um Thread específico pelo id.
     *
     * @return void
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Aqui eu digo que esse Eloquete (Thread) tem muitos replies
     *
     * @return void
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Aqui eu digo que esse thread pertence a um dono
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Aqui eu digo que threads podem adicionar respostas.
     *
     * @return void
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Aqui eu digo que um canal pode ter threads.
     *
     * @return void
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
