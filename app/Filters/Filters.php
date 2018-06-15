<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * Essa classe abstrata é por que eu posso ter diferentes tipos de filtros.
 * Esses filtros virarão outras classes concretas que herdarão seus métodos e atributos.
 */
abstract class Filters
{
    protected $request;
    protected $builder;
    protected $filters = [];//eu meio que uso isso aqui no ThreadFilters, mas lá eu passo um valor.. aí no método apply, vai esse valor passado que foi pegado no getFilters

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

    /**
     * Recebe os filtros.
     *
     * @return void
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
