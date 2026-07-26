<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';  // ← Utilise notre table

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
        'photo_profil',
        'bio',
        'num_whatsapp',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Laravel attend 'password' par défaut, on le redirige vers 'mot_de_passe'
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // =============================================
    // RELATIONS
    // =============================================

    /**
 * Les artistes que le client a en favoris
 */
public function favoris()
{
    return $this->hasMany(Favori::class, 'client_id');
}

/**
 * Les clients qui ont ajouté cet artiste en favori
 */
public function estFavoriDe()
{
    return $this->hasMany(Favori::class, 'artiste_id');
}

    public function titres()
    {
        return $this->hasMany(Titre::class, 'artiste_id');
    }

    public function portefeuille()
    {
        return $this->hasOne(Portefeuille::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function demandesRetrait()
    {
        return $this->hasMany(DemandeRetrait::class, 'artiste_id');
    }

    public function contactsDebloques()
    {
        return $this->hasMany(ContactDebloque::class, 'sponsor_id');
    }

    public function artistesDebloques()
    {
        return $this->belongsToMany(User::class, 'contacts_debloques', 'sponsor_id', 'artiste_id')
                    ->withPivot('montant_paye', 'commande_id')
                    ->withTimestamps();
    }

    public function sponsorsQuiOntDebloque()
    {
        return $this->belongsToMany(User::class, 'contacts_debloques', 'artiste_id', 'sponsor_id')
                    ->withPivot('montant_paye', 'commande_id')
                    ->withTimestamps();
    }

    public function publications()
    {
        return $this->hasMany(Publication::class, 'artiste_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function accesTitres()
    {
        return $this->hasMany(AccesTitre::class);
    }

    // =============================================
    // SCOPES
    // =============================================

    public function scopeArtistes($query)
    {
        return $query->where('role', 'artiste');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeSponsors($query)
    {
        return $query->where('role', 'sponsor');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // =============================================
    // ACCESSORS
    // =============================================

    public function getNomCompletAttribute()
    {
        return $this->nom;
    }

    public function getWhatsappLinkAttribute()
    {
        if ($this->num_whatsapp) {
            return 'https://wa.me/' . $this->num_whatsapp;
        }
        return null;
    }

    // =============================================
    // MUTATORS
    // =============================================

    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    // =============================================
    // VÉRIFICATIONS DE RÔLE
    // =============================================

    public function isArtiste()
    {
        return $this->role === 'artiste';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSponsor()
    {
        return $this->role === 'sponsor';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }
}