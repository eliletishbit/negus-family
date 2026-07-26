<?php

namespace App\Http\Controllers;

use App\Models\Titre;
use App\Models\Portefeuille;
use App\Models\DemandeRetrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtisteController extends Controller
{
    /**
     * Dashboard de l'artiste
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistiques
        $totalTitres = Titre::where('artiste_id', $user->id)->count();
        $totalVentes = Titre::where('artiste_id', $user->id)->sum('nb_ventes');
        $totalFans = 0; // À calculer si tu as une table de followers
        
        // Portefeuille
        $portefeuille = Portefeuille::where('user_id', $user->id)->first();
        $solde = $portefeuille ? $portefeuille->solde_disponible : 0;
        $enAttente = $portefeuille ? $portefeuille->solde_en_attente : 0;
        
        // Derniers titres
        $derniersTitres = Titre::where('artiste_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();
        
        // Demandes de retrait récentes
        $demandesRetrait = DemandeRetrait::where('artiste_id', $user->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard.artiste', compact(
            'totalTitres',
            'totalVentes',
            'totalFans',
            'solde',
            'enAttente',
            'derniersTitres',
            'demandesRetrait'
        ));
    }

    /**
     * Liste des titres de l'artiste
     */
    public function titres()
    {
        $titres = Titre::where('artiste_id', Auth::id())->latest()->get();
        return view('artiste.titres', compact('titres'));
    }

    /**
     * Formulaire de création d'un titre
     */
    public function create()
    {
        return view('artiste.create-titre');
    }

    /**
     * Enregistrer un nouveau titre
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'commission' => 'nullable|numeric|min:0|max:100',
            'type' => 'required|in:son,video',
            'fichier_apercu' => 'nullable|file|mimes:mp3,wav,mp4|max:20480',
            'fichier_complet' => 'nullable|file|mimes:mp3,wav,mp4|max:51200',
            'status' => 'nullable|in:en_attente,publie,rejete',
        ]);

        // Gestion des fichiers
        $fichierApercuPath = null;
        $fichierCompletPath = null;

        if ($request->hasFile('fichier_apercu')) {
            $fichierApercuPath = $request->file('fichier_apercu')->store('titres/apercus', 'public');
        }

        if ($request->hasFile('fichier_complet')) {
            $fichierCompletPath = $request->file('fichier_complet')->store('titres/complets', 'public');
        }

        $titre = Titre::create([
            'artiste_id' => Auth::id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'commission' => $request->commission ?? 10,
            'fichier_apercu' => $fichierApercuPath,
            'fichier_complet' => $fichierCompletPath,
            'type' => $request->type,
            'nb_ventes' => 0,
            'status' => $request->status ?? 'en_attente',
        ]);

        return redirect()->route('artiste.titres')
            ->with('success', '✅ Titre "' . $titre->titre . '" publié avec succès !');
    }

    /**
     * Formulaire d'édition d'un titre
     */
    public function edit($id)
    {
        $titre = Titre::where('artiste_id', Auth::id())->findOrFail($id);
        return view('artiste.edit-titre', compact('titre'));
    }

    /**
     * Mettre à jour un titre
     */
    public function update(Request $request, $id)
    {
        $titre = Titre::where('artiste_id', Auth::id())->findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'commission' => 'nullable|numeric|min:0|max:100',
            'type' => 'required|in:son,video',
            'fichier_apercu' => 'nullable|file|mimes:mp3,wav,mp4|max:20480',
            'fichier_complet' => 'nullable|file|mimes:mp3,wav,mp4|max:51200',
            'status' => 'nullable|in:en_attente,publie,rejete',
        ]);

        // Gestion des fichiers
        if ($request->hasFile('fichier_apercu')) {
            // Supprimer l'ancien fichier
            if ($titre->fichier_apercu) {
                Storage::disk('public')->delete($titre->fichier_apercu);
            }
            $titre->fichier_apercu = $request->file('fichier_apercu')->store('titres/apercus', 'public');
        }

        if ($request->hasFile('fichier_complet')) {
            if ($titre->fichier_complet) {
                Storage::disk('public')->delete($titre->fichier_complet);
            }
            $titre->fichier_complet = $request->file('fichier_complet')->store('titres/complets', 'public');
        }

        // Mise à jour des champs
        $titre->titre = $request->titre;
        $titre->description = $request->description;
        $titre->prix = $request->prix;
        $titre->commission = $request->commission ?? 10;
        $titre->type = $request->type;
        if ($request->has('status')) {
            $titre->status = $request->status;
        }
        $titre->save();

        return redirect()->route('artiste.titres')
            ->with('success', '✅ Titre "' . $titre->titre . '" mis à jour avec succès !');
    }

    /**
     * Supprimer un titre
     */
    public function destroy($id)
    {
        $titre = Titre::where('artiste_id', Auth::id())->findOrFail($id);
        
        // Supprimer les fichiers associés
        if ($titre->fichier_apercu) {
            Storage::disk('public')->delete($titre->fichier_apercu);
        }
        if ($titre->fichier_complet) {
            Storage::disk('public')->delete($titre->fichier_complet);
        }
        
        $titreNom = $titre->titre;
        $titre->delete();

        return redirect()->route('artiste.titres')
            ->with('success', '🗑️ Titre "' . $titreNom . '" supprimé avec succès !');
    }

    /**
     * Portefeuille de l'artiste
     */
    public function portefeuille()
    {
        $portefeuille = Portefeuille::where('user_id', Auth::id())->first();
        $retraits = DemandeRetrait::where('artiste_id', Auth::id())->latest()->get();
        return view('artiste.portefeuille', compact('portefeuille', 'retraits'));
    }

    /**
     * Demander un retrait
     */
    public function demanderRetrait(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1000'
        ]);

        $portefeuille = Portefeuille::where('user_id', Auth::id())->first();

        // Vérifier si le portefeuille existe
        if (!$portefeuille) {
            $portefeuille = Portefeuille::create([
                'user_id' => Auth::id(),
                'solde_disponible' => 0,
                'solde_en_attente' => 0,
                'solde_total_gagne' => 0,
            ]);
        }

        // Vérifier le solde
        if ($portefeuille->solde_disponible < $request->montant) {
            return back()->with('error', '❌ Solde insuffisant. Solde disponible : ' . number_format($portefeuille->solde_disponible, 0) . ' F');
        }

        // Créer la demande de retrait
        $retrait = DemandeRetrait::create([
            'artiste_id' => Auth::id(),
            'montant' => $request->montant,
            'statut' => 'en_attente',
            'motif_rejet' => null,
            'reference_transfert' => null,
            'validee_par' => null,
        ]);

        // Déduire le montant du solde disponible
        $portefeuille->solde_disponible -= $request->montant;
        $portefeuille->solde_en_attente += $request->montant;
        $portefeuille->save();

        return back()->with('success', '✅ Demande de retrait de ' . number_format($request->montant, 0) . ' F envoyée avec succès !');
    }

    /**
     * Incrémenter les ventes d'un titre (appelé après un achat)
     */
    public function incrementerVentes($titreId)
    {
        $titre = Titre::findOrFail($titreId);
        $titre->nb_ventes += 1;
        $titre->save();
        return $titre;
    }
}