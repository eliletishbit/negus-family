<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Titre;
use App\Models\AccesTitre;
use App\Models\ContactDebloque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtistePublicController extends Controller
{
    public function index()
    {
        $artistes = User::where('role', 'artiste')
            ->withCount('titres')
            ->having('titres_count', '>', 0)
            ->orderBy('titres_count', 'desc')
            ->paginate(12);

        return view('public.artistes.index', compact('artistes'));
    }

    public function show($id)
    {
        $artiste = User::where('role', 'artiste')
            ->withCount('titres')
            ->findOrFail($id);

        $titres = Titre::where('artiste_id', $id)
            ->where('status', 'publie')
            ->latest()
            ->get();

        $estDebloque = false;
        $titresAchetes = [];

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'sponsor') {
                $estDebloque = ContactDebloque::where('sponsor_id', $user->id)
                    ->where('artiste_id', $id)
                    ->exists();
            }

            if ($user->role === 'client') {
                $titresAchetes = AccesTitre::where('user_id', $user->id)
                    ->pluck('titre_id')
                    ->toArray();
            }
        }

        return view('public.artistes.show', compact(
            'artiste',
            'titres',
            'estDebloque',
            'titresAchetes'
        ));
    }
}