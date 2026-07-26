<?php

namespace App\Http\Controllers;

use App\Models\ContactDebloque;
use App\Models\Portefeuille;
use App\Models\User;
use App\Models\Titre;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    /**
     * Dashboard du sponsor
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Statistiques
        $titresDebloques = ContactDebloque::where('sponsor_id', $user->id)->count();
        $artistesSoutenus = ContactDebloque::where('sponsor_id', $user->id)
            ->distinct('artiste_id')
            ->count();

        // Portefeuille
        $portefeuille = Portefeuille::where('user_id', $user->id)->first();
        $solde = $portefeuille ? $portefeuille->solde_disponible : 0;
        $totalDepense = ContactDebloque::where('sponsor_id', $user->id)->sum('montant_paye');

        // Derniers contacts débloqués
        $derniersContacts = ContactDebloque::where('sponsor_id', $user->id)
            ->with('artiste')
            ->latest()
            ->limit(5)
            ->get();

        // Notifications
        $notifications = 0;

        return view('dashboard.sponsor', compact(
            'titresDebloques',
            'artistesSoutenus',
            'solde',
            'totalDepense',
            'derniersContacts',
            'notifications'
        ));
    }

    /**
     * Explorer les artistes
     */
    public function explorer()
    {
        $artistes = User::where('role', 'artiste')
            ->withCount('titres')
            ->having('titres_count', '>', 0)
            ->get();

        // Vérifier quels artistes sont déjà débloqués
        $debloques = ContactDebloque::where('sponsor_id', Auth::id())
            ->pluck('artiste_id')
            ->toArray();

        return view('sponsor.explorer', compact('artistes', 'debloques'));
    }

    /**
     * Débloquer un artiste
     */
    public function debloquer($artisteId)
    {
        $user = Auth::user();
        $artiste = User::where('role', 'artiste')->findOrFail($artisteId);

        // Vérifier si déjà débloqué
        $existe = ContactDebloque::where('sponsor_id', $user->id)
            ->where('artiste_id', $artisteId)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Cet artiste est déjà débloqué.');
        }

        // Prix de déblocage (exemple : 1000 F par déblocage)
        $montant = 1000;

        // Vérifier le solde
        $portefeuille = Portefeuille::where('user_id', $user->id)->first();
        if (!$portefeuille || $portefeuille->solde_disponible < $montant) {
            return back()->with('error', 'Solde insuffisant. Rechargez votre portefeuille.');
        }

        // Créer une commande fictive
        $commande = Commande::create([
            'client_id' => $user->id,
            'total' => $montant,
            'statut' => 'paye',
            'mode_livraison' => 'electronique',
        ]);

        // Créer le déblocage
        ContactDebloque::create([
            'sponsor_id' => $user->id,
            'artiste_id' => $artisteId,
            'commande_id' => $commande->id,
            'montant_paye' => $montant,
        ]);

        // Déduire le solde
        $portefeuille->solde_disponible -= $montant;
        $portefeuille->save();

        return back()->with('success', 'Artiste "' . $artiste->nom . '" débloqué avec succès !');
    }

    /**
     * Liste des contacts débloqués
     */
    public function contacts()
    {
        $contacts = ContactDebloque::where('sponsor_id', Auth::id())
            ->with('artiste', 'commande')
            ->latest()
            ->get();
        return view('sponsor.contacts', compact('contacts'));
    }

    /**
     * Portefeuille du sponsor
     */
    public function portefeuille()
    {
        $portefeuille = Portefeuille::where('user_id', Auth::id())->first();
        $transactions = ContactDebloque::where('sponsor_id', Auth::id())
            ->latest()
            ->get();
        return view('sponsor.portefeuille', compact('portefeuille', 'transactions'));
    }

    /**
     * Recharger le portefeuille
     */
    public function recharger(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1000',
        ]);

        $portefeuille = Portefeuille::where('user_id', Auth::id())->first();

        if (!$portefeuille) {
            $portefeuille = Portefeuille::create([
                'user_id' => Auth::id(),
                'solde_disponible' => 0,
                'solde_total_gagne' => 0,
            ]);
        }

        $portefeuille->solde_disponible += $request->montant;
        $portefeuille->save();

        return back()->with('success', 'Portefeuille rechargé de ' . number_format($request->montant, 0, ',', ' ') . ' F');
    }
}