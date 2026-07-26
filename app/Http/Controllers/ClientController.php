<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\AccesTitre;
use App\Models\Favori;
use App\Models\Titre;
use App\Models\User;
use App\Models\Portefeuille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Statistiques
        $titresAchetes = AccesTitre::where('user_id', $user->id)->count();
        $commandes = Commande::where('client_id', $user->id)->count();
        $depenses = Commande::where('client_id', $user->id)->where('statut', 'paye')->sum('total');
        $favoris = Favori::where('client_id', $user->id)->count();

        // Derniers titres achetés
        $derniersTitres = AccesTitre::where('user_id', $user->id)
            ->with('titre.artiste')
            ->latest()
            ->limit(5)
            ->get();

        // Dernières commandes
        $dernieresCommandes = Commande::where('client_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        // Artistes recommandés
        $artistesRecommandes = User::where('role', 'artiste')
            ->withCount('titres')
            ->having('titres_count', '>', 0)
            ->orderBy('titres_count', 'desc')
            ->limit(4)
            ->get();

        // Notifications
        $notifications = 0;

        // Fallback : si aucune donnée, on passe une collection vide
        if (!$derniersTitres) {
            $derniersTitres = collect();
        }
        if (!$dernieresCommandes) {
            $dernieresCommandes = collect();
        }
        if (!$artistesRecommandes) {
            $artistesRecommandes = collect();
        }

        return view('dashboard.client', compact(
            'titresAchetes',
            'commandes',
            'depenses',
            'favoris',
            'derniersTitres',
            'dernieresCommandes',
            'artistesRecommandes',
            'notifications'
        ));
    }

    /**
     * Liste des titres achetés
     */
    public function titres()
    {
        $titres = AccesTitre::where('user_id', Auth::id())
            ->with('titre.artiste')
            ->latest()
            ->get();
        return view('client.titres', compact('titres'));
    }

    /**
     * Liste des commandes
     */
    public function commandes()
    {
        $commandes = Commande::where('client_id', Auth::id())->latest()->get();
        return view('client.commandes', compact('commandes'));
    }

    /**
     * Détail d'une commande
     */
    public function showCommande($id)
    {
        $commande = Commande::where('client_id', Auth::id())
            ->with('lignes.titre', 'lignes.produit')
            ->findOrFail($id);
        return view('client.show-commande', compact('commande'));
    }

    /**
     * Liste des favoris
     */
    public function favoris()
    {
        $favoris = Favori::where('client_id', Auth::id())
            ->with('artiste')
            ->get();
        return view('client.favoris', compact('favoris'));
    }

    /**
     * Ajouter un favori
     */
    public function ajouterFavoris($artisteId)
    {
        $existe = Favori::where('client_id', Auth::id())
            ->where('artiste_id', $artisteId)
            ->exists();

        if (!$existe) {
            Favori::create([
                'client_id' => Auth::id(),
                'artiste_id' => $artisteId,
            ]);
            return back()->with('success', 'Artiste ajouté aux favoris !');
        }

        return back()->with('error', 'Cet artiste est déjà dans vos favoris.');
    }

    /**
     * Retirer un favori
     */
    public function retirerFavoris($artisteId)
    {
        Favori::where('client_id', Auth::id())
            ->where('artiste_id', $artisteId)
            ->delete();

        return back()->with('success', 'Artiste retiré des favoris.');
    }

    /**
     * Détail d'un titre acheté
     */
    public function showTitre($id)
    {
        $acces = AccesTitre::where('user_id', Auth::id())
            ->with('titre.artiste')
            ->findOrFail($id);
        return view('client.show-titre', compact('acces'));
    }
}