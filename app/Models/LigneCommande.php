<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'lignes_commande';

    protected $fillable = [
        'commande_id',
        'titre_id',
        'produit_id',
        'prix_unitaire',
        'quantite',
        'commission_ligne',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function titre()
    {
        return $this->belongsTo(Titre::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function getSousTotalAttribute()
    {
        return $this->prix_unitaire * $this->quantite;
    }

    public function getCommissionMontantAttribute()
    {
        return $this->sous_total * ($this->commission_ligne / 100);
    }

    public function getMontantArtisteAttribute()
    {
        return $this->sous_total - $this->commission_montant;
    }
}