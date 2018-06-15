<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];//o mesmo filters da classe abstrata Filters, só que com o valor

    /**
     * Filtra a query pelo nome de usuário.
     *
     * @param string $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
