<?php

namespace App\Http\Controllers;

use App\Models\Titre;
use App\Models\User;
use App\Models\AccesTitre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller
{
    /**
     * Page d'exploration des titres (accessible à tous)
     */
    public function index()
    {
        // Récupérer les titres publiés
        $titres = Titre::where('status', 'publie')
            ->with('artiste')
            ->latest()
            ->paginate(12);

        // Récupérer les titres en vogue (les plus vendus)
        $titresEnVogue = Titre::where('status', 'publie')
            ->with('artiste')
            ->orderBy('nb_ventes', 'desc')
            ->limit(6)
            ->get();

        // Récupérer les artistes en vedette
       
            $artistesEnVedette = User::where('role', 'artiste')
                ->whereHas('titres')
                ->withCount('titres')
                ->orderBy('titres_count', 'desc')
                ->limit(6)
                ->get();

        // Vérifier quels titres l'utilisateur a déjà achetés (si connecté)
        $titresAchetes = [];
        if (Auth::check()) {
            $titresAchetes = AccesTitre::where('user_id', Auth::id())
                ->pluck('titre_id')
                ->toArray();
        }

        return view('explore.index', compact(
            'titres',
            'titresEnVogue',
            'artistesEnVedette',
            'titresAchetes'
        ));
    }

    /**
     * Détail d'un titre (accessible à tous)
     */
    public function showTitre($id)
    {
        $titre = Titre::where('status', 'publie')
            ->with('artiste')
            ->findOrFail($id);

        // Vérifier si l'utilisateur a déjà acheté ce titre (si connecté)
        $aAchete = false;
        if (Auth::check()) {
            $aAchete = AccesTitre::where('user_id', Auth::id())
                ->where('titre_id', $id)
                ->exists();
        }

        return view('explore.show', compact('titre', 'aAchete'));
    }
}