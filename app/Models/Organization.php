<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory;

    protected $table = "judge_organization";

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'judge_profile_organizations', 'organization_id', 'profile_id');
    }

    public function problems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class, 'judge_problem_organizations', 'organization_id', 'problem_id');
    }
}
