<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvenementController extends Controller
{
    /**
     * Affiche la liste des événements à venir
     */
    public function index()
    {
        $evenements = Evenement::where('est_actif', true)
                            ->where('date_debut', '>', now())
                            ->orderBy('date_debut', 'asc')
                            ->get();

        return Inertia::render('Evenements', [
            'evenements' => $evenements
        ]);
    }

    /**
     * Inscription à un événement
     */
    public function inscrire($id)
    {
        $evenement = Evenement::findOrFail($id);

        // Vérifie s'il reste des places
        if ($evenement->participants_inscrits < $evenement->nombre_places) {
            $evenement->increment('participants_inscrits');
            return redirect()->back()->with('success', 'Inscription réussie !');
        }

        return redirect()->back()->with('error', 'Complet ! Plus de places disponibles.');
    }
}
