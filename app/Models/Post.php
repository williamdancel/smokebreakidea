<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'author_name',
        'author_email',
        'status',
        'is_from_non_registered_user',
        'cigarette_id',
        'cigarettes_count',
        'rating',
    ];

    protected $casts = [
        'is_from_non_registered_user' => 'boolean',
        'cigarettes_count' => 'integer',
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cigarette()
    {
        return $this->belongsTo(Cigarette::class);
    }
}