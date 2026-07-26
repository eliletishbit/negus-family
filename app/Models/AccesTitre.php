<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesTitre extends Model
{
    use HasFactory;

    protected $table = 'acces_titres';

    protected $fillable = [
        'user_id',
        'titre_id',
        'token_acces',
        'expire_le',
    ];

    protected $casts = [
        'expire_le' => 'datetime',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }

    public function titre()
    {
        return $this->belongsTo(Titre::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function estValide()
    {
        if ($this->expire_le === null) {
            return true;
        }
        return now()->lessThan($this->expire_le);
    }

    public function genererToken()
    {
        return bin2hex(random_bytes(32));
    }
}