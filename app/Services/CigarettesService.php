<?php

namespace App\Services;

use App\Models\Cigarette;
use Illuminate\Database\Eloquent\Collection;

class CigarettesService extends BaseService
{
    protected $model = Cigarette::class;

    public function __construct()
    {
        $this->model = new Cigarette();
    }

    public function getAvailableCigarettes(): Collection
    {
        return $this->model->with('brand')
                          ->where('is_available', true)
                          ->orderBy('name')
                          ->get();
    }

    public function searchCigarettes(string $searchTerm): Collection
    {
        return $this->model->with('brand')
                          ->where(function($query) use ($searchTerm) {
                              $query->where('name', 'LIKE', "%{$searchTerm}%")
                                    ->orWhereHas('brand', function($q) use ($searchTerm) {
                                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                                    });
                          })
                          ->where('is_available', true)
                          ->orderBy('name')
                          ->get();
    }
}