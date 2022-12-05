<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sessions extends Model
{
    use HasFactory;

    protected $table = "sessions";

    protected $fillable = ['label'];

    public function hasQuestions(): HasMany
    {
        return $this->hasMany(Questions::class, 'sessions_id');
    }
}
