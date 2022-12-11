<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\LaravelGame
 *
 * @property string $id
 * @property string $player
 * @property string $laravel_session
 * @property int $step
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LaravelJoker[] $jokers
 * @property-read int|null $jokers_count
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame query()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereLaravelSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame wherePlayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelGame whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LaravelGame extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'game';

    public function jokers(): HasMany
    {
        return $this->hasMany(LaravelJoker::class, "game");
    }

    public function session(): HasOne
    {
        return $this->hasOne(LaravelSession::class, "id", "laravel_session");
    }
}
