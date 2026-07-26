<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titre extends Model
{
    use HasFactory;

    protected $fillable = [
        'artiste_id',
        'titre',
        'description',
        'prix',
        'commission',
        'fichier_apercu',
        'fichier_complet',
        'type',
        'nb_ventes',
        'status',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function artiste()
    {
        return $this->belongsTo(User::class, 'artiste_id');
    }

    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function acces()
    {
        return $this->hasMany(AccesTitre::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function estGratuit()
    {
        return $this->prix <= 0;
    }

    public function getPrixAvecCommissionAttribute()
    {
        return $this->prix * (1 - $this->commission / 100);
    }

    public function incrementerVentes()
    {
        $this->nb_ventes++;
        $this->save();
    }

    public function getFichierCompletUrlAttribute()
    {
        // Route sécurisée pour télécharger le fichier
        return route('titres.telecharger', $this->id);
    }
}