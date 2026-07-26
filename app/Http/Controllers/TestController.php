<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Reservation; // IMPORTANT : Ne pas oublier d'importer le modèle
use Illuminate\Support\Facades\Auth; // IMPORTANT : Ne pas oublier d'importer Auth

class TestController extends Controller
{
    // On supprime le constructeur et la variable $this->stock qui ne servaient à rien

    public function reserver(Shop $shop, Request $request)
    {
        // 1. Validation des données entrantes (ex: l'id du panier choisi par l'utilisateur)
        $request->validate([
            'nompanier_id' => 'required|exists:paniers,id' // On vérifie que le panier existe en BDD
        ]);

        // 2. Vérification du stock réel de la boutique (en BDD)
        if ($shop->stock <= 0) {
            return redirect()->route('panier.reservations')->with('error', 'Plus de panier disponible dans cette boutique.');
        }

        // 3. Vérification si l'utilisateur a déjà réservé aujourd'hui
        $user = Auth::user();
        $hasAlreadyReservedToday = Reservation::where('user_id', $user->id)
            ->whereDate('created_at', today()) // Souvent le champ s'appelle created_at par défaut
            ->exists();

        if ($hasAlreadyReservedToday) {
            return redirect()->route('panier.reservations')->with('error', 'Vous avez déjà une réservation pour aujourd’hui.');
        }

        // 4. Traitement de la réservation (On utilise une transaction de préférence, mais restons simple)
        // Décrémentation du stock directement en BDD
        $shop->decrement('stock'); 

        // Création de la réservation
        Reservation::create([
            'user_id'     => Auth::id(), // Syntaxe correcte avec parenthèses
            'panier_id'   => $request->nompanier_id, // Syntaxe corrigée
            'reserved_at' => now(),
            'status'      => 'en_attente',
            'quantite'    => 1
        ]);

        return redirect()->route('panier.reservations')->with('success', 'Réservation effectuée avec succès !');
    }

    public function reservations()
    {
        $user = Auth::user();
        
        // Récupérer les réservations de l'utilisateur connecté
        $myreservations = Reservation::where('user_id', $user->id)->get();
       
        // Syntaxe compact() corrigée
        return view('reservations.index', compact('myreservations')); 
    }
}
