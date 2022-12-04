<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\LaravelSession
 *
 * @property string $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LaravelQuestion[] $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LaravelSession extends Model
{
    use HasFactory;
    use HasUuids;

    public function questions(): HasMany
    {
        return $this->hasMany(LaravelQuestion::class, "session");
    }
}
