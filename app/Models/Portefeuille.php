<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portefeuille extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',           // ← changé
        'solde_disponible',
        'solde_en_attente',
        'solde_total_gagne',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');  // ← précise la clé
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function crediter($montant)
    {
        $this->solde_disponible += $montant;
        $this->solde_total_gagne += $montant;
        $this->save();
    }

    public function debiter($montant)
    {
        if ($this->solde_disponible >= $montant) {
            $this->solde_disponible -= $montant;
            $this->save();
            return true;
        }
        return false;
    }

    public function peutRetirer($montant)
    {
        return $this->solde_disponible >= $montant;
    }
}