<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'address',
        'city',
        'state',
        'zip_code',
        'birth_date',
        'social_facebook',
        'social_instagram',
        'social_linkedin',
        'preferences',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'preferences' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}