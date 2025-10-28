<?php

namespace App\Http\Filters\V1;
use App\Http\Filters\V1\QueryFilter;

class UserFilter extends QueryFilter
{
    /**
     * Filter by status.
     */
    public function id($value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function email($value)
    {
        
        // Decodificar la URL en caso de que venga codificada
        $decodedValue = urldecode($value);
        
        // Convertir * a % si es necesario (para compatibilidad)
        $likeValue = str_replace('*', '%', $decodedValue);
        
        // Si no contiene %, añadir comodines para búsqueda parcial
        if (strpos($likeValue, '%') === false) {
            $likeValue = '%' . $likeValue . '%';
        }
                
        return $this->builder->where('email', 'like', $likeValue);
    }    

    public function name($value)
    {
        
        // Decodificar la URL en caso de que venga codificada
        $decodedValue = urldecode($value);

        // Convertir * a % si es necesario (para compatibilidad)
        $likeValue = str_replace('*', '%', $decodedValue);

        // Si no contiene %, añadir comodines para búsqueda parcial
        if (strpos($likeValue, '%') === false) {
            $likeValue = '%' . $likeValue . '%';
        }

        return $this->builder->where('name', 'like', $likeValue);
    
    }    
    
    public function created_at($value)
    {
       
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }


    public function updated_at($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
    
}