<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total',
        'commission_totale',
        'mode_livraison',
        'statut',
        'ref_fedapay',
        'methode_paiement',
        'date_livraison',
        'adresse_livraison',
        'notes'
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }

    // Une commande a un seul paiement associé
    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'commande_id');
    }

    public function contactDebloque()
    {
        return $this->hasOne(ContactDebloque::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function estPayee()
    {
        return $this->statut === 'paye';
    }

    public function marquerPayee($refFedaPay = null)
    {
        $this->statut = 'paye';
        if ($refFedaPay) {
            $this->ref_fedapay = $refFedaPay;
        }
        $this->save();

        // Créditer les artistes
        $this->crediterArtistes();
    }

    public function crediterArtistes()
    {
        foreach ($this->lignes as $ligne) {
            if ($ligne->titre_id) {
                $titre = $ligne->titre;
                $montantArtiste = $ligne->prix_unitaire * (1 - $ligne->commission_ligne / 100);
                
                // Créditer le portefeuille de l'artiste
                $portefeuille = $titre->artiste->portefeuille;
                if ($portefeuille) {
                    $portefeuille->crediter($montantArtiste * $ligne->quantite);
                }

                // Incrémenter les ventes
                $titre->incrementerVentes();

                // Créer l'accès pour le client
                AccesTitre::create([
                    'utilisateur_id' => $this->client_id,
                    'titre_id' => $titre->id,
                    'token_acces' => bin2hex(random_bytes(32)),
                    'expire_le' => null, // Accès à vie
                ]);
            }
        }
    }
}