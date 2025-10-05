<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cigarette extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'strength',
        'description',
        'tar_content',
        'nicotine_content',
        'is_available',
    ];

    protected $casts = [
        'tar_content' => 'decimal:2',
        'nicotine_content' => 'decimal:2',
        'is_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(CigaretteBrand::class);
    }

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
}