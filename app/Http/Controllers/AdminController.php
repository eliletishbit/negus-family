<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Titre;
use App\Models\Commande;
use App\Models\DemandeRetrait;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Statistiques globales
        $totalUsers = User::count();
        $totalArtistes = User::where('role', 'artiste')->count();
        $totalClients = User::where('role', 'client')->count();
        $totalSponsors = User::where('role', 'sponsor')->count();
        $totalTitres = Titre::count();
        $titresEnAttente = Titre::where('status', 'en_attente')->count();
        $totalCommandes = Commande::count();
        $commandesPayees = Commande::where('statut', 'paye')->count();
        $caTotal = Commande::where('statut', 'paye')->sum('total');
        $retraitsEnAttente = DemandeRetrait::where('statut', 'en_attente')->count();

        // Dernières activités
        $dernieresCommandes = Commande::with('client')->latest()->limit(5)->get();
        $derniersTitres = Titre::with('artiste')->latest()->limit(5)->get();
        $derniersRetraits = DemandeRetrait::with('artiste')->latest()->limit(5)->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalArtistes',
            'totalClients',
            'totalSponsors',
            'totalTitres',
            'titresEnAttente',
            'totalCommandes',
            'commandesPayees',
            'caTotal',
            'retraitsEnAttente',
            'dernieresCommandes',
            'derniersTitres',
            'derniersRetraits'
        ));
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function titres()
    {
        $titres = Titre::with('artiste')->latest()->get();
        return view('admin.titres', compact('titres'));
    }

    public function commandes()
    {
        $commandes = Commande::with('client')->latest()->get();
        return view('admin.commandes', compact('commandes'));
    }

    public function retraits()
    {
        $retraits = DemandeRetrait::with('artiste')->latest()->get();
        return view('admin.retraits', compact('retraits'));
    }

    /*valider une demande de retrait */ 
    public function validerRetrait($id)
    {
        $retrait = DemandeRetrait::findOrFail($id);
        
        // Vérifier que le retrait est bien en attente
        if ($retrait->statut !== 'en_attente') {
            return back()->with('error', 'Ce retrait a déjà été traité.');
        }

        // Mettre à jour le statut
        $retrait->statut = 'validee';
        $retrait->save();

        // Notification à l'artiste (si le helper existe)
        // if (class_exists('App\Helpers\NotificationHelper')) {
        //     NotificationHelper::send(
        //         $retrait->artiste_id,
        //         '💰 Retrait validé',
        //         'Votre demande de retrait de ' . number_format($retrait->montant, 0) . ' F a été validée.',
        //         'retrait',
        //         route('artiste.portefeuille')
        //     );
        // }

        return back()->with('success', '✅ Retrait validé avec succès !');
    }

    /**
     * Rejeter une demande de retrait
     */
    public function rejeterRetrait($id)
    {
        $retrait = DemandeRetrait::findOrFail($id);
        
        // Vérifier que le retrait est bien en attente
        if ($retrait->statut !== 'en_attente') {
            return back()->with('error', 'Ce retrait a déjà été traité.');
        }

        // Mettre à jour le statut
        $retrait->statut = 'rejetee';
        $retrait->save();

        return back()->with('success', '❌ Retrait rejeté.');
    } 

}