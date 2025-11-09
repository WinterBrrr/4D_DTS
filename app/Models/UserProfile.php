<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nickname',
        'department',
        'identity',
        'age',
        'occupation',
        'nationality',
        'contact_number',
        'address',
        'gender',
        'profile_photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
