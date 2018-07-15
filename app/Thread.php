<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected $with = ['owner', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

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
        return $this->hasMany(Reply::class)->withCount('favorites');
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
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

    /**
     * Aqui eu pego a query que retornou do método apply de ThreadFilters.
     * Quando eu chamar o método apply aqui
     *
     * Aplica todos os filtros relevantes de threads
     *
     * @param Builder $query
     * @param ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        return  $filters->apply($query);
    }
}
