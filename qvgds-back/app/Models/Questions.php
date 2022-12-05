<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questions extends Model
{
    use HasFactory;

    protected $table = "questions";

    protected $fillable = ['label', 'order', 'sessions_id'];

    public function hasAnswers(): HasMany
    {
        return $this->hasMany(Answers::class, 'questions_id');
    }
}
