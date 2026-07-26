<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

   
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
    $user = $request->user();

    // 1. Remplir le modèle avec les données textuelles validées (sauf la photo)
    $user->fill($request->safe()->except(['photo_profil']));

    // 2. Gérer l'upload de la photo de profil si un nouveau fichier est fourni
    if ($request->hasFile('photo_profil')) {
        
        // Optionnel : Supprimer l'ancienne photo si elle existe pour ne pas encombrer le serveur
        if ($user->photo_profil) {
            Storage::disk('public')->delete($user->photo_profil);
        }

        // Stocker le fichier dans le dossier 'storage/app/public/avatars'
        // store() génère un nom unique automatiquement et retourne le chemin (ex: avatars/abc123xyz.jpg)
        $path = $request->file('photo_profil')->store('avatars', 'public');
        
        // Sauvegarder le chemin dans l'attribut du modèle
        $user->photo_profil = $path;
        
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePassword(Request $request): RedirectResponse
{
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'mot_de_passe' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = $request->user();
    $user->mot_de_passe = Hash::make($request->mot_de_passe);
    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Mot de passe mis à jour avec succès !');
}
}
