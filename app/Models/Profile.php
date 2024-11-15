<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "judge_profile";

    // boot
    protected static function boot() {
        parent::boot();

        // tự động lấy user khi truy vấn profile
        static::retrieved(function($profile) {
            $profile->user;
        });
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
