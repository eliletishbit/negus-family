<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'prix',
        'stock',
        'type',
        'image_url',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function estPhysique()
    {
        return $this->type === 'physique';
    }

    public function estService()
    {
        return $this->type === 'service';
    }

    public function estEnStock()
    {
        return $this->stock > 0;
    }

    public function decrementerStock($quantite = 1)
    {
        if ($this->estPhysique() && $this->stock >= $quantite) {
            $this->stock -= $quantite;
            $this->save();
            return true;
        }
        return false;
    }

    public function vendeur()
{
    return $this->belongsTo(User::class, 'user_id');
}

}