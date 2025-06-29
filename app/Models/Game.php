<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $current_number
 * @property array<array-key, mixed>|null $called_numbers
 * @property bool $is_active
 * @property int|null $winner
 * @property int|null $winner_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $winnerUser
 *
 * @method static Builder<static>|Game active()
 * @method static \Database\Factories\GameFactory factory($count = null, $state = [])
 * @method static Builder<static>|Game inactive()
 * @method static Builder<static>|Game newModelQuery()
 * @method static Builder<static>|Game newQuery()
 * @method static Builder<static>|Game query()
 * @method static Builder<static>|Game whereCalledNumbers($value)
 * @method static Builder<static>|Game whereCreatedAt($value)
 * @method static Builder<static>|Game whereCurrentNumber($value)
 * @method static Builder<static>|Game whereId($value)
 * @method static Builder<static>|Game whereIsActive($value)
 * @method static Builder<static>|Game whereUpdatedAt($value)
 * @method static Builder<static>|Game whereWinner($value)
 * @method static Builder<static>|Game whereWinnerScore($value)
 *
 * @mixin \Eloquent
 */
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

    /**
     * @return BelongsTo<User,Game>
     */
    public function winnerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner');
    }

    /**
     * @param  Builder<Model>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder<Model>  $query
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }
}
