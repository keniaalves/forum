<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * É aqui que se aplica os filtros (para o construtor)
     * que serão passados para a página de listagem das threads.
     * Filtro de usuário.Seu retorno será capturado pelo método
     * scopeFilter do model.
     *
     *
     * @param array $builder
     * @return query
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
