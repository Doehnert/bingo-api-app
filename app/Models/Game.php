<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $fillable = [
        'current_number',
        'called_numbers',
        'is_active',
        'winner',
        'winner_score',
    ];

    protected $casts = [
        'called_numbers' => 'array',
        'is_active' => 'boolean',
        'winner_score' => 'integer',
    ];

    public function winnerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner');
    }

    /**
     * Scope a query to only include active games.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeInactive(Builder $query): void
    {
        $query->where('is_active', false);
    }
}
