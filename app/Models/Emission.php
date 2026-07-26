<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emission extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'code_youtube',
        'categorie',
        'est_en_vogue',
    ];

    protected $casts = [
        'est_en_vogue' => 'boolean',
    ];

    // =============================================
    // MÉTHODES
    // =============================================

    public function getYoutubeUrlAttribute()
    {
        return 'https://www.youtube.com/embed/' . $this->code_youtube;
    }

    public function getYoutubeThumbnailAttribute()
    {
        return 'https://img.youtube.com/vi/' . $this->code_youtube . '/hqdefault.jpg';
    }
}