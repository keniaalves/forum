<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    /**
     * Aqui eu digo que esse reply pertence a um dono
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
