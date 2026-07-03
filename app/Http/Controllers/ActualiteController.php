<?php
// app/Http/Controllers/ActualiteController.php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Evenement;
use Inertia\Inertia;

class ActualiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// app/Http/Controllers/ActualiteController.php
public function index()
{
    $actualitesMonde = Actualite::where('est_publie', true)
        ->orderBy('date_publication', 'desc')
        ->get();

    $evenements = Evenement::where('est_actif', true)
        ->where('date_debut', '>', now())
        ->orderBy('date_debut')
        ->get();

    return Inertia::render('Actualite', [
        'actualitesMonde' => $actualitesMonde,
        'evenements' => $evenements
    ]);
}
}
