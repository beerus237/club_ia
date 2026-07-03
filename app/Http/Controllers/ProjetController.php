<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Inertia\Inertia;

class ProjetController extends Controller
{
    public function index()
    {
        $projets = Projet::orderBy('created_at', 'desc')->get();

        $categories = $projets
            ->pluck('categorie')
            ->filter()
            ->unique()
            ->values();

        return Inertia::render('Realisations', [
            'projets' => $projets,
            'categories' => $categories,
        ]);
    }
}
