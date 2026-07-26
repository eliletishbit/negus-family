<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeRetrait extends Model
{
    use HasFactory;

    protected $table = 'demandes_retrait';

    protected $fillable = [
        'artiste_id',
        'montant',
        'statut',
        'reference_transfert',
        'validee_par',
        'motif_rejet',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function artiste()
    {
        return $this->belongsTo(User::class, 'artiste_id');
    }

    public function valideur()
    {
        return $this->belongsTo(User::class, 'validee_par');
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function estEnAttente()
    {
        return $this->statut === 'en_attente';
    }

    public function estValidee()
    {
        return $this->statut === 'validee';
    }

    public function estPayee()
    {
        return $this->statut === 'payee';
    }

    public function valider($adminId, $reference = null)
    {
        $this->statut = 'validee';
        $this->validee_par = $adminId;
        if ($reference) {
            $this->reference_transfert = $reference;
        }
        $this->save();
    }

    public function rejeter($adminId, $motif)
    {
        $this->statut = 'rejetee';
        $this->validee_par = $adminId;
        $this->motif_rejet = $motif;
        $this->save();
    }

    public function marquerPayee()
    {
        $this->statut = 'payee';
        $this->save();
    }
}