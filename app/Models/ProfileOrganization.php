<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ProfileOrganization extends Pivot
{
    use HasFactory;

    protected $table = "judge_profile_organizations";
}
