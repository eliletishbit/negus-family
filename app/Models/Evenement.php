<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_evenement',
        'lieu',
        'prix_entree',
        'affiche_url',
    ];

    protected $casts = [
        'date_evenement' => 'datetime',
    ];

    // =============================================
    // MÉTHODES
    // =============================================

    public function estPasse()
    {
        return now()->greaterThan($this->date_evenement);
    }

    public function estBientot()
    {
        return now()->diffInDays($this->date_evenement) <= 7;
    }
}