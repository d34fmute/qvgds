<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $table = "answers";

    protected $fillable = ['label', 'is_fifty', 'state', 'questions_id'];
}
