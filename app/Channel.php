<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Aqui eu sobrescrevo esse método do laravel
     * dizendo que, ao invés de obter os dados desse
     * model pelo id, que é padrão, eu quero pelo slug.
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Estabelece a relação entre channels e threads,
     * de forma que um channel possui vários threads e
     * fornece essa consulta.
     *
     * @return void
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
