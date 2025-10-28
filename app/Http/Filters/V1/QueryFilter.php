<?php

namespace App\Http\Filters\V1;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class QueryFilter
{
    protected $builder;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter($arr)
    {
        foreach ($arr as $name => $value) {
            if (method_exists($this, $name)) {
                $this->$name($value);
            }
        }

      
        return $this->builder;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        // Procesar específicamente los filtros anidados como filter[title]
        if ($this->request->has('filter')) {
            $filters = $this->request->get('filter');
            if (is_array($filters)) {
                foreach ($filters as $name => $value) {
                    if (method_exists($this, $name)) {
                        Log::info('Calling filter method', ['method' => $name, 'value' => $value]);
                        $this->$name($value);
                    }
                }
            }
        } else {
            // Solo procesar parámetros directos si no hay filtros anidados
            foreach ($this->request->all() as $name => $value) {
                if (method_exists($this, $name)) {
                    $this->$name($value);
                }
            }
        }

        return $this->builder;
    }
}