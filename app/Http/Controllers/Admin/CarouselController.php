<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $slides = CarouselSlide::orderBy('ordre')->get();
        return inertia('Admin/Carousel/Index', compact('slides'));
    }

    public function create()
    {
        return inertia('Admin/Carousel/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url',
            'ordre' => 'nullable|integer',
        ]);

        $validated['image_url'] = $this->resolveImageUrl($request, 'carousel');

        if (!$validated['image_url']) {
            return back()->withErrors(['image' => "Veuillez fournir une image (fichier ou URL)."])->withInput();
        }

        CarouselSlide::create($validated);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide ajouté avec succès');
    }

    public function edit(CarouselSlide $carousel)
    {
        return inertia('Admin/Carousel/Edit', [
            'slide' => $carousel
        ]);
    }

    public function update(Request $request, CarouselSlide $carousel)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url',
            'ordre' => 'nullable|integer',
            'est_actif' => 'boolean'
        ]);

        $validated['image_url'] = $this->resolveImageUrl($request, 'carousel', $carousel->image_url);

        if (!$validated['image_url']) {
            return back()->withErrors(['image' => "Veuillez fournir une image (fichier ou URL)."])->withInput();
        }

        $carousel->update($validated);

        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide modifié avec succès');
    }

    public function destroy(CarouselSlide $carousel)
    {
        $this->deleteLocalImageIfOwned($carousel->image_url);
        $carousel->delete();
        return redirect()->route('admin.carousel.index')
            ->with('success', 'Slide supprimé avec succès');
    }
}
