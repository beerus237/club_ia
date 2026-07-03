<?php
namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\MeilleureRealisation;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $carouselSlides = CarouselSlide::where('est_actif', true)
            ->orderBy('ordre')
            ->get()
            ->map(function ($slide) {
                $title = $slide->titre ?? $slide->caption ?? $slide->title ?? '';

                return [
                    'caption' => $title,
                    'title' => $title,
                    'titre' => $title,
                    'description' => $slide->description ?? '',
                    'image_url' => $slide->image_url,
                ];
            });

        $bestAchievement = MeilleureRealisation::where('est_actif', true)
            ->first();

        $stats = [
            ['value' => '50+', 'label' => 'Projets Innovants'],
            ['value' => '200+', 'label' => 'Membres Actifs'],
            ['value' => '15+', 'label' => 'Partenariats'],
            ['value' => '98%', 'label' => 'Satisfaction'],
        ];

         $executiveMembers = [
            [
                'name' => 'DIMBONGO Henri Stéphane',
                'position' => 'Président',
                'bio' => 'Leader visionnaire du club, il pilote les grandes orientations stratégiques et inspire l’excellence collective.',
                'photo_url' => '/images/membres/DIMBONGO HENRI STEPHANE-PRESIDENT.jpg',
            ],
            [
                'name' => 'ETAH Ewane Ramsey Etah',
                'position' => 'Censeur principal',
                'bio' => 'Pilier de la discipline et de la conformité, il accompagne le bureau dans la rigueur et la qualité des actions.',
                'photo_url' => '/images/membres/ETAH EWANE RAMSEY ETAH-Censeur principal   .jpg',
            ],
            [
                'name' => 'LIZA Enone Ngoh Loice',
                'position' => 'Secrétaire général',
                'bio' => 'Elle coordonne les échanges, les documents et l’organisation du club avec précision et dynamisme.',
                'photo_url' => '/images/membres/LIZA.jpg',
            ],
            [
                'name' => 'MOLADEL Munpubuyi Ivana Karla',
                'position' => 'Chef département Relations & Partenariats',
                'bio' => 'Elle développe les liens institutionnels et favorise la visibilité du club à travers des partenariats solides.',
                'photo_url' => '/images/membres/MOLADEL_MUNPUBUYI_IVANA_KARLA_Chef_Departement_Relations_Partenariats.jpg',
            ],
            [
                'name' => 'MEPEYOU Tounkam Gilles Morel',
                'position' => 'Chef département Éthique, Innovation & Incubation',
                'bio' => 'Il porte les valeurs de l’innovation responsable et accompagne les initiatives de création et d’incubation.',
                'photo_url' => '/images/membres/MEPEYOU_TOUNKAM_GILLES_MOREL_Chef_Departement_Ethique_Innovation_Incubation.jpg',
            ],
            [
                'name' => 'RAMADANG Tokam Paul Wilfried',
                'position' => 'Chef département Veille scientifique & technologique',
                'bio' => 'Il veille sur les tendances, les innovations et les opportunités qui peuvent enrichir les projets du club.',
                'photo_url' => '/images/membres/RAMADANG_TOKAM_PAUL_WILFRIED_Chef_Departement_Veille_Scientifique_Technologique.jpg',
            ],
            [
                'name' => 'BRYAN NLEND Linkholn',
                'position' => 'Chef département Infographie & Design',
                'bio' => 'Il conçoit et diffuse les messages du club, en valorisant ses actions et en renforçant son image.',
                'photo_url' => '/images/membres/BRYAN_NLEND_BIHEGUEL_LINKHOLN_Chef_Departement_Infographie_Design.jpg',
            ],
            [
                'name' => 'KOUONANG NJOUONANG Yves Thierry',
                'position' => 'Chef département Marketing & Services',
                'bio' => 'Il élabore les stratégies de communication et de marketing pour promouvoir le club et ses projets.',
                'photo_url' => '/images/membres/KOUONANG.jpg',
            ],
            [
                'name' => 'TCHINDA DJATE Hurchill',
                'position' => 'Chef département Formations Techniques',
                'bio' => 'Il organise et encadre les formations techniques pour développer les compétences des membres du club.',                'photo_url' => '/images/membres/MOUKAM_TCHOUANGUE_MERVILLE_Chef_Departement_Formations_Techniques.jpg',
                'photo_url' => '/images/membres/TCHINDA_DJATE_HURCHIL_Chef_Departement_Formations_Technique.jpg'
            ],
             [
                'name' => 'TCHANTCHOU SANDJONG Steve Wilfried',
                'position' => 'Chef département Recherche & Développement',
                'bio' => 'Il coordonne les projets de recherche et d’innovation afin de promouvoir le développement de solutions technologiques au sein du club.',
                'photo_url' => '/images/membres/TCHANTCHOU.jpeg'
            ],
        ];

        $president = ['name' => 'DIMBONGO Henri Stéphane'];

        return Inertia::render('Home', [
            'carouselSlides' => $carouselSlides,
            'bestAchievement' => $bestAchievement ? [
                'title' => $bestAchievement->titre,
                'category' => $bestAchievement->categorie,
                'description' => $bestAchievement->description,
                'image_url' => $bestAchievement->image_url,
                'link' => $bestAchievement->lien,
            ] : null,
            'stats' => $stats,
            'executiveMembers' => $executiveMembers,
            'president' => $president,
        ]);
    }
}
