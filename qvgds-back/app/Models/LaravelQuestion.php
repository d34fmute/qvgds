<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LaravelQuestion
 *
 * @property string $id
 * @property string $session
 * @property int $step
 * @property string $question
 * @property string $good_answer
 * @property string $bad_answer1
 * @property string $bad_answer2
 * @property string $bad_answer3
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereBadAnswer1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereBadAnswer2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereBadAnswer3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereGoodAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|LaravelQuestion whereId($value)
 */
class LaravelQuestion extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;
    protected $table = 'question';
}
