<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Filters\V1\QueryFilter;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'author_id', // V2 compatibility
        'priority',
        'internal_notes',
        'view_count',
    ];

    public function author(): BelongsTo
    {
        // V2: Usar author_id si existe, fallback a user_id para compatibilidad V1
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function user(): BelongsTo
    {
        // V1: Mantener user_id para compatibilidad
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
