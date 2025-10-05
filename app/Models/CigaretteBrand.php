<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CigaretteBrand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manufacturer',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cigarettes()
    {
        return $this->hasMany(Cigarettes::class);
    }
}