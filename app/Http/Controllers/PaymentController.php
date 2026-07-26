<?php

namespace App\Http\Controllers;

use FedaPay\FedaPay;
use FedaPay\Transaction;
use App\Models\Commande;
use App\Models\Titre;
use App\Models\AccesTitre;
use App\Models\Portefeuille;
use App\Models\LigneCommande;
use App\Models\Paiement;
use App\Models\ContactDebloque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Constructeur : Configuration de FedaPay
     */
    public function __construct()
    {
        // 1. Récupérer la clé API
        $apiKey = config('services.fedapay.api_key');
        FedaPay::setApiKey($apiKey);

        // 2. Récupérer le mode (sandbox ou live)
        $mode = config('services.fedapay.mode', 'live');
        FedaPay::setEnvironment($mode);

        // 3. Définir l'ID du compte Marchand FedaPay
        $accountId = config('services.fedapay.account_id');
        if ($accountId) {
            FedaPay::setAccountId($accountId);
        }

        // 4. Désactiver la vérification SSL pour les tests en local
        FedaPay::setVerifySslCerts(false);
    }

    /**
     * INITIER UN PAIEMENT POUR UN TITRE (Client)
     */
    public function initierAchatTitre(Request $request)
    {
        $request->validate([
            'titre_id' => 'required|exists:titres,id',
        ]);

        $titre = Titre::findOrFail($request->titre_id);
        $user = Auth::user();
        $montant = $titre->prix;

        try {
            // 1. Créer la transaction FedaPay
            $transaction = Transaction::create([
                'description' => 'Achat du titre : ' . $titre->titre,
                'amount' => (int)($montant*1), // en xof
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('payment.callback'),
                'mode' => 'mtn',
                'customer' => [
                    'firstname' => $user->nom ?? 'Client',
                    'lastname' => '',
                    'email' => $user->email,
                    'phone_number' => [
                        'number' => $user->num_whatsapp ?? '+22966666600',
                        'country' => 'bj',
                    ],
                ],
            ]);

            // 2. Vérifier que l'URL de paiement existe
            $paymentUrl = $transaction->payment_url;
            if (empty($paymentUrl)) {
                Log::error('URL de paiement vide pour la transaction : ' . $transaction->id);
                return back()->with('error', '❌ URL de paiement non disponible. Veuillez réessayer.');
            }

            // 3. Créer la commande en base
            $commande = Commande::create([
                'client_id' => $user->id,
                'total' => $montant,
                'statut' => 'en_attente',
                'mode_livraison' => 'electronique',
                'ref_fedapay' => $transaction->id,
            ]);

            // 4. Ajouter la ligne de commande
            LigneCommande::create([
                'commande_id' => $commande->id,
                'titre_id' => $titre->id,
                'prix_unitaire' => $montant,
                'quantite' => 1,
                'commission_ligne' => 10,
            ]);

            // 5. Créer le paiement en base
            Paiement::create([
                'commande_id' => $commande->id,
                'fedapay_transaction_id' => $transaction->id,
                'montant' => $montant,
                'devise' => 'XOF',
                'statut' => 'en_attente',
            ]);

            // 6. Stocker l'ID de la commande en session
            session(['commande_id' => $commande->id]);

            // 7. Rediriger vers l'URL de paiement FedaPay
            return redirect()->to($paymentUrl);

        } catch (\Exception $e) {
            Log::error('Erreur FedaPay (Achat titre) : ' . $e->getMessage());
            return back()->with('error', '❌ Erreur lors du paiement : ' . $e->getMessage());
        }
    }

    /**
     * INITIER UN PAIEMENT POUR DÉBLOQUER UN ARTISTE (Sponsor)
     */
    public function initierDeblocage(Request $request)
    {
        $request->validate([
            'artiste_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $artiste = User::findOrFail($request->artiste_id);
        $montant = 1000;

        try {
            // 1. Créer la transaction FedaPay
            $transaction = Transaction::create([
                'description' => 'Déblocage de l\'artiste : ' . $artiste->nom,
                'amount' => $montant * 100,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('payment.callback'),
                'mode' => 'mtn',
                'customer' => [
                    'firstname' => $user->nom ?? 'Sponsor',
                    'lastname' => '',
                    'email' => $user->email,
                    'phone_number' => [
                        'number' => $user->num_whatsapp ?? '+22966666600',
                        'country' => 'bj',
                    ],
                ],
            ]);

            // 2. Vérifier l'URL de paiement
            $paymentUrl = $transaction->payment_url;
            if (empty($paymentUrl)) {
                Log::error('URL de paiement vide pour le déblocage : ' . $transaction->id);
                return back()->with('error', '❌ URL de paiement non disponible.');
            }

            // 3. Créer la commande
            $commande = Commande::create([
                'client_id' => $user->id,
                'total' => $montant,
                'statut' => 'en_attente',
                'mode_livraison' => 'electronique',
                'ref_fedapay' => $transaction->id,
            ]);

            // 4. Créer le paiement
            Paiement::create([
                'commande_id' => $commande->id,
                'fedapay_transaction_id' => $transaction->id,
                'montant' => $montant,
                'devise' => 'XOF',
                'statut' => 'en_attente',
            ]);

            // 5. Stocker les informations en session
            session([
                'commande_id' => $commande->id,
                'deblocage_artiste_id' => $artiste->id,
                'deblocage_montant' => $montant,
            ]);

            // 6. Rediriger vers FedaPay
            return redirect()->to($paymentUrl);

        } catch (\Exception $e) {
            Log::error('Erreur FedaPay (Déblocage) : ' . $e->getMessage());
            return back()->with('error', '❌ Erreur lors du déblocage : ' . $e->getMessage());
        }
    }

    /**
     * CALLBACK - Redirection après paiement
     */
    public function callback(Request $request)
    {
        $transactionId = $request->transaction_id;

        if (!$transactionId) {
            return redirect()->route('explore')->with('error', '❌ Transaction non trouvée.');
        }

        // Récupérer le paiement
        $paiement = Paiement::where('fedapay_transaction_id', $transactionId)->first();

        if ($paiement && $paiement->statut === 'paye') {
            return view('fedapay.callback')->with('success', '✅ Votre paiement a été validé avec succès !');
        }

        // Si c'est un déblocage
        if (session('deblocage_artiste_id')) {
            return redirect()->route('sponsor.dashboard')->with('info', '⏳ Paiement en cours de validation...');
        }

        return view('fedapay.callback')->with('info', '⏳ Votre paiement est en cours de traitement.');
    }

    /**
     * WEBHOOK - Notification automatique de FedaPay
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('Webhook FedaPay reçu', $payload);

        if ($payload['event'] === 'transaction.succeeded') {
            $transaction = $payload['data'];
            $fedapayTransactionId = $transaction['id'];

            // Récupérer le paiement
            $paiement = Paiement::where('fedapay_transaction_id', $fedapayTransactionId)->first();

            if (!$paiement) {
                Log::error('Paiement non trouvé pour transaction: ' . $fedapayTransactionId);
                return response()->json(['status' => 'error', 'message' => 'Paiement not found'], 404);
            }

            if ($paiement->statut === 'paye') {
                return response()->json(['status' => 'already_processed']);
            }

            $commande = $paiement->commande;

            // 1. Marquer le paiement comme payé
            $paiement->statut = 'paye';
            $paiement->save();

            // 2. Mettre à jour la commande
            $commande->statut = 'paye';
            $commande->save();

            // 3. Traiter les lignes de commande
            foreach ($commande->lignes as $ligne) {
                if ($ligne->titre_id) {
                    // 3a. Créer l'accès pour le client
                    AccesTitre::create([
                        'user_id' => $commande->client_id,
                        'titre_id' => $ligne->titre_id,
                        'token_acces' => bin2hex(random_bytes(32)),
                        'expire_le' => null, // Accès à vie
                    ]);

                    // 3b. Incrémenter les ventes
                    $titre = Titre::find($ligne->titre_id);
                    if ($titre) {
                        $titre->nb_ventes += 1;
                        $titre->save();

                        // 3c. Créditer l'artiste
                        $portefeuille = Portefeuille::where('user_id', $titre->artiste_id)->first();
                        if ($portefeuille) {
                            $montantArtiste = $ligne->prix_unitaire * (1 - ($ligne->commission_ligne / 100));
                            $portefeuille->crediter($montantArtiste * $ligne->quantite);
                        }
                    }
                }
            }

            // 4. Vérifier si c'est un déblocage d'artiste
            $sessionDeblocage = session('deblocage_artiste_id');
            if ($sessionDeblocage) {
                ContactDebloque::create([
                    'sponsor_id' => $commande->client_id,
                    'artiste_id' => $sessionDeblocage,
                    'commande_id' => $commande->id,
                    'montant_paye' => $commande->total,
                ]);
                session()->forget('deblocage_artiste_id');
            }

            // 5. Notification (si le système de notifications est implémenté)
            // NotificationHelper::send(...);

            Log::info('Paiement traité avec succès: ' . $fedapayTransactionId);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * INITIER UN RETRAIT (Artiste)
     */
    public function initierRetrait(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();
        $montant = $request->montant;

        $portefeuille = Portefeuille::where('user_id', $user->id)->first();

        if (!$portefeuille || $portefeuille->solde_disponible < $montant) {
            return back()->with('error', '❌ Solde insuffisant. Solde disponible : ' . number_format($portefeuille->solde_disponible ?? 0, 0, ',', ' ') . ' F');
        }

        // Créer une demande de retrait
        $retrait = \App\Models\DemandeRetrait::create([
            'artiste_id' => $user->id,
            'montant' => $montant,
            'statut' => 'en_attente',
        ]);

        // Déduire du solde disponible
        $portefeuille->solde_disponible -= $montant;
        $portefeuille->solde_en_attente += $montant;
        $portefeuille->save();

        // Notification (si le système de notifications est implémenté)
        // NotificationHelper::send(...);

        return back()->with('success', '✅ Demande de retrait de ' . number_format($montant, 0, ',', ' ') . ' F envoyée avec succès !');
    }
}