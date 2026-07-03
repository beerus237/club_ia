<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Evenement;
use App\Models\Projet;
use App\Models\Contribution;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'actualites_count' => Actualite::count(),
            'evenements_count' => Evenement::count(),
            'projets_count' => Projet::count(),
            'contributions_pending' => Contribution::where('statut', 'en_attente')->count(),
        ];

        $recentContributions = Contribution::with('user')
            ->where('statut', 'en_attente')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($contribution) {
                return [
                    'id' => $contribution->id,
                    'titre' => $contribution->titre,
                    'type' => $contribution->type,
                    'statut' => $contribution->statut,
                    'created_at' => $contribution->created_at->format('d/m/Y H:i'),
                    'user' => $contribution->user ? $contribution->user->name : 'Anonyme'
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentContributions' => $recentContributions
        ]);
    }
}
