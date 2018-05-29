<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public function path()
    {
        return '/threads/' . $this->id;
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
}
