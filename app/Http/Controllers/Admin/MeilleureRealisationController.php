<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Models\MeilleureRealisation;
use Illuminate\Http\Request;

class MeilleureRealisationController extends Controller
{
    use HandlesImageUpload;

    public function edit()
    {
        $realisation = MeilleureRealisation::where('est_actif', true)->first();
        return inertia('Admin/MeilleureRealisation/Edit', compact('realisation'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url',
            'lien' => 'nullable|url'
        ]);

        $existing = MeilleureRealisation::where('est_actif', true)->first();
        $validated['image_url'] = $this->resolveImageUrl($request, 'meilleure-realisation', $existing?->image_url);

        // Désactiver l'ancienne réalisation active
        MeilleureRealisation::where('est_actif', true)->update(['est_actif' => false]);

        // Créer ou mettre à jour la nouvelle
        if ($request->has('id') && $request->id) {
            $realisation = MeilleureRealisation::find($request->id);
            $realisation->update(array_merge($validated, ['est_actif' => true]));
        } else {
            MeilleureRealisation::create(array_merge($validated, ['est_actif' => true]));
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Meilleure réalisation mise à jour avec succès');
    }
}
