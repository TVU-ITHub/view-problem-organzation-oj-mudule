<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $table = "judge_problem";

    public function submissions() {
        return $this->hasMany(Submission::class, 'problem_id', 'id');
    }
}
