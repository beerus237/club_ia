<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    /**
     * Affiche le formulaire de contribution
     */
    public function create()
    {
        return Inertia::render('CollecteDonnees');
    }

    /**
     * Stocke une nouvelle contribution
     */
    public function store(Request $request)
    {
        // Règles de validation de base + spécifiques au type. On laisse
        // Laravel gérer nativement l'échec de validation (ValidationException) :
        // Inertia détecte automatiquement la requête (en-tête X-Inertia) et
        // redirige en repeuplant `form.errors` côté Vue, sans qu'on ait besoin
        // de fabriquer une réponse JSON personnalisée.
        $rules = array_merge([
            'type' => 'required|in:image,texte,dataset',
            'titre' => 'required|string|max:255',
        ], $this->getValidationRules($request->input('type')));

        $validatedData = $request->validate($rules);

        $fileData = $this->handleFileUpload($request, $validatedData['type']);

        $contributionData = [
            'user_id' => Auth::check() ? Auth::id() : null,
            'type' => $validatedData['type'],
            'titre' => $validatedData['titre'],
            'statut' => 'en_attente',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ];

        $typeSpecificData = match ($validatedData['type']) {
            'image' => [
                'nature' => $validatedData['nature'],
                'description' => $validatedData['description'],
            ],
            'texte' => [
                'thematique' => $validatedData['thematique'],
                'langue' => $validatedData['langue'],
                'contenu_texte' => $validatedData['contenu_texte'],
            ],
            'dataset' => [
                'domaine' => $validatedData['domaine'],
                'description' => $validatedData['description'],
            ],
            default => [],
        };

        Contribution::create(array_merge($contributionData, $typeSpecificData, $fileData));

        return redirect()->route('collecte-donnees')
            ->with('success', 'Merci pour votre contribution ! Elle sera examinée par notre équipe.');
    }

    /**
     * Règles de validation spécifiques par type
     */
    private function getValidationRules($type)
    {
        $baseRules = [
            'type' => 'required|in:image,texte,dataset',
            'titre' => 'required|string|max:255',
        ];

        $typeRules = match($type) {
            'image' => [
                'nature' => 'required|in:portrait,medical,agriculture,elevage,culture,urbain,nature',
                'description' => 'required|string|min:10|max:1000',
                'images' => 'required|array|min:1|max:10',
                'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:10240',
            ],
            'texte' => [
                'thematique' => 'required|in:contes,traditions,histoire,savoir,quotidien,autre',
                'langue' => 'required|in:français,anglais,ewondo,dual,bassa,autre',
                'contenu_texte' => 'required|string|min:1|max:1000000000',
            ],
            'dataset' => [
                'domaine' => 'required|in:sante,agriculture,elevage,environnement,education,economie,transport,autre',
                'description' => 'required|string|min:1|max:2000',
                'fichier_dataset' => 'required|file|mimes:csv,txt,xlsx,xls,json|max:51200',
            ],
            default => []
        };

        return array_merge($baseRules, $typeRules);
    }

    /**
     * Gestion de l'upload des fichiers
     */
    private function handleFileUpload(Request $request, $type)
    {
        $fileData = [];

        try {
            switch ($type) {
                case 'image':
                    if ($request->hasFile('images')) {
                        $imagePaths = [];
                        foreach ($request->file('images') as $image) {
                            $path = $image->store('contributions/images', 'public');
                            $imagePaths[] = $path;
                        }
                        // Le modèle Contribution caste "chemin_fichier" en 'array',
                        // qui se charge lui-même de l'encodage JSON : on assigne donc
                        // le tableau PHP brut, sans l'encoder manuellement ici.
                        $fileData['chemin_fichier'] = $imagePaths;
                        $fileData['nom_fichier'] = count($imagePaths) . ' image(s)';
                    }
                    break;

                case 'dataset':
                    if ($request->hasFile('fichier_dataset')) {
                        $file = $request->file('fichier_dataset');
                        $path = $file->store('contributions/datasets', 'public');
                        $fileData['chemin_fichier'] = $path;
                        $fileData['nom_fichier'] = $file->getClientOriginalName();
                    }
                    break;
            }
        } catch (\Exception $e) {
            \Log::error('Erreur upload fichier: ' . $e->getMessage());
            throw new \Exception('Erreur lors de l\'upload des fichiers: ' . $e->getMessage());
        }

        return $fileData;
    }

    /**
     * Affiche les statistiques des contributions
     */
    public function statistiques()
    {
        $stats = [
            'total' => Contribution::count(),
            'par_type' => Contribution::groupBy('type')
                ->selectRaw('type, count(*) as total')
                ->get(),
            'par_statut' => Contribution::groupBy('statut')
                ->selectRaw('statut, count(*) as total')
                ->get(),
        ];

        return Inertia::render('ResultatsAnalyse', [
            'statistiques' => $stats
        ]);
    }
}
