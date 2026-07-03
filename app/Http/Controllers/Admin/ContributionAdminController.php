<?php
// app/Http/Controllers/Admin/ContributionAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContributionAdminController extends Controller
{
    /**
     * Affiche la liste des contributions pour modération
     */
    public function index(Request $request)
    {
        $query = Contribution::with('user')
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }

        $contributions = $query->paginate(15);

        return Inertia::render('Admin/Contributions/Index', [
            'contributions' => $contributions,
            'filters' => $request->only(['type', 'statut'])
        ]);
    }

    /**
     * Affiche les détails d'une contribution
     */
    public function show($id)
    {
        $contribution = Contribution::with('user')->findOrFail($id);

        return Inertia::render('Admin/Contributions/Show', [
            'contribution' => $contribution
        ]);
    }

    /**
     * Approuve une contribution
     */
    public function approve($id)
    {
        $contribution = Contribution::findOrFail($id);

        $contribution->update([
            'statut' => 'approuve',
            'traite_le' => now(),
        ]);

        return redirect()->back()->with('success', 'Contribution approuvée avec succès');
    }

    /**
     * Rejette une contribution
     */
    public function reject($id)
    {
        $contribution = Contribution::findOrFail($id);

        $contribution->update([
            'statut' => 'rejete',
            'traite_le' => now(),
        ]);

        return redirect()->back()->with('success', 'Contribution rejetée avec succès');
    }

    /**
     * Télécharge un fichier de contribution
     */
    public function download($id)
    {
        $contribution = Contribution::findOrFail($id);

        if (!in_array($contribution->type, ['image', 'dataset'])) {
            abort(404);
        }

        $filePath = $contribution->chemin_fichier;

        // Gestion des images multiples
        if ($contribution->type === 'image' && is_array($filePath)) {
            $filePath = $filePath[0] ?? null;

            if (!$filePath) {
                abort(404);
            }
        } elseif ($contribution->type === 'image' && is_string($filePath) && str_starts_with(trim($filePath), '[')) {
            // Cas où le cast array n'a pas été appliqué (chaîne JSON brute)
            $paths = json_decode($filePath, true);
            $filePath = $paths[0] ?? null;

            if (!$filePath) {
                abort(404);
            }
        }

        if (!\Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        // Le nom "lisible" stocké (nom_fichier) n'a pas forcément d'extension
        // (ex: "3 images" pour un lot d'images) : on reconstruit toujours le
        // nom de téléchargement à partir du fichier réel sur le disque pour
        // garantir que l'extension soit toujours présente.
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = $contribution->nom_fichier ?: pathinfo($filePath, PATHINFO_BASENAME);

        if ($extension && !str_ends_with(strtolower($downloadName), '.' . strtolower($extension))) {
            $downloadName = pathinfo($downloadName, PATHINFO_FILENAME) . '.' . $extension;
        }

        return \Storage::disk('public')->download($filePath, $downloadName);
    }
}
