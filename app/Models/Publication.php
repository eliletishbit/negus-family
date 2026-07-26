<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'artiste_id',
        'contenu',
        'media_url',
    ];

    // =============================================
    // RELATIONS
    // =============================================

    public function artiste()
    {
        return $this->belongsTo(User::class, 'artiste_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    // =============================================
    // MÉTHODES
    // =============================================

    public function getNbLikesAttribute()
    {
        return $this->likes()->count();
    }

    public function getNbCommentairesAttribute()
    {
        return $this->commentaires()->count();
    }
}