<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Game extends Model
{
    use HasFactory;
    use Searchable;

    public const DEFAULT_FILE_EXTENSION = 'pgn';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'opponent',
        'moves',
        'result',
    ];

    protected $casts = [
        'moves' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function analysis(): HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    public function scopeByUser($builder, int $id)
    {
        return $builder->where('user_id', $id);
    }

    public function searchableAs(): string
    {
        return 'game_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'moves' => $this->moves,
            'opponent' => $this->opponent,
            'user_id' => $this->user->id,
        ];
    }
}
