<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artiste_id',
    ];

    /**
     * Relation avec le client (celui qui ajoute en favori)
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relation avec l'artiste (celui qui est ajouté en favori)
     */
    public function artiste()
    {
        return $this->belongsTo(User::class, 'artiste_id');
    }
}