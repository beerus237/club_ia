<?php
// app/Http/Controllers/Admin/ActualiteAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ActualiteAdminController extends Controller
{
    use HandlesImageUpload;

    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $actualites = Actualite::orderBy('date_publication', 'desc')
        ->get()
        ->filter(function ($actualite) {
            return $actualite !== null && $actualite->id !== null;
        });

    return Inertia::render('Admin/Actualites/Index', [
        'actualites' => $actualites
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Actualites/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie' => 'required|in:Santé,Agriculture,Éducation,Technologie,Économie,Environnement,Autre',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url',
            'lien_externe' => 'nullable|url',
            'date_publication' => 'required|date',
            'auteur' => 'nullable|string|max:255',
            'est_publie' => 'boolean'
        ]);

        $validated['image_url'] = $this->resolveImageUrl($request, 'actualites');

        Actualite::create($validated);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actualite $actualite)
    {
        return Inertia::render('Admin/Actualites/Show', [
            'actualite' => $actualite
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actualite $actualite)
    {
        return Inertia::render('Admin/Actualites/Edit', [
            'actualite' => $actualite
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actualite $actualite)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'categorie' => 'required|in:Santé,Agriculture,Éducation,Technologie,Économie,Environnement,Autre',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url',
            'lien_externe' => 'nullable|url',
            'date_publication' => 'required|date',
            'auteur' => 'nullable|string|max:255',
            'est_publie' => 'boolean'
        ]);

        $validated['image_url'] = $this->resolveImageUrl($request, 'actualites', $actualite->image_url);

        $actualite->update($validated);

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actualite $actualite)
    {
        $this->deleteLocalImageIfOwned($actualite->image_url);
        $actualite->delete();

        return redirect()->route('admin.actualites.index')
            ->with('success', 'Actualité supprimée avec succès');
    }
}
