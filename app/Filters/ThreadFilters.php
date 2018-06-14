<?php

namespace App\Filters;

use App\User;
use Illuminate\Support\Facades\Request;

class ThreadFilters
{
    protected $request;
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * É aqui que se aplica os filtros que serão passados para
     * a página de listagem das threads. Filtro de usuário.
     * Seu retorno será capturado pelo método scopeFilter do
     * model.
     *
     *
     * @param array $builder
     * @return query
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        if (!$username = $this->request->by) {
            return $builder;
        }

        return $this->by($username);
    }

    public function by()
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
