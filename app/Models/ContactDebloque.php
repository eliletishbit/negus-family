<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDebloque extends Model
{
    use HasFactory;

    protected $table = 'contacts_debloques';

    protected $fillable = [
        'sponsor_id',
        'artiste_id',
        'commande_id',
        'montant_paye',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function artiste()
    {
        return $this->belongsTo(User::class, 'artiste_id');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}