<?php

namespace App\Http\Filters\V1;

use Illuminate\Support\Facades\Log;

class TicketFilter extends QueryFilter
{
    /**
     * Filter by status.
     */
    public function status($value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function title($value)
    {
        // Logging para depuración
        Log::info('TicketFilter title method called', [
            'original_value' => $value,
            'decoded_value' => urldecode($value)
        ]);
        
        // Decodificar la URL en caso de que venga codificada
        $decodedValue = urldecode($value);
        
        // Convertir * a % si es necesario (para compatibilidad)
        $likeValue = str_replace('*', '%', $decodedValue);
        
        // Si no contiene %, añadir comodines para búsqueda parcial
        if (strpos($likeValue, '%') === false) {
            $likeValue = '%' . $likeValue . '%';
        }
        
        Log::info('TicketFilter final like value', ['like_value' => $likeValue]);
        
        return $this->builder->where('title', 'like', $likeValue);
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