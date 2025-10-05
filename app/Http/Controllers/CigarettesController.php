<?php

namespace App\Http\Controllers;

use App\Services\CigarettesService;
use Illuminate\Http\Request;

class CigarettesController extends Controller
{
    protected $cigarettesService;

    public function __construct(CigarettesService $cigarettesService)
    {
        $this->cigarettesService = $cigarettesService;
    }

    public function index()
    {
        $cigarettes = $this->cigarettesService->getAvailableCigarettes();

        return response()->json([
            'success' => true,
            'data' => $cigarettes
        ]);
    }

    public function show($id)
    {
        $cigarette = $this->cigarettesService->find($id);

        if (!$cigarette || !$cigarette->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'Cigarette not found'
            ], 404);
        }

        $cigarette->load('brand');

        return response()->json([
            'success' => true,
            'data' => $cigarette
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);

        $cigarettes = $this->cigarettesService->searchCigarettes($request->q);

        return response()->json([
            'success' => true,
            'data' => $cigarettes
        ]);
    }
}