<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LaravelJoker
 *
 * @property string $type
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker query()
 * @mixin \Eloquent
 * @property string $game
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker whereGame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelJoker whereUpdatedAt($value)
 */
class LaravelJoker extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'game_joker';
}
