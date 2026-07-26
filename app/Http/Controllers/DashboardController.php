<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Rediriger selon le rôle
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'artiste') {
            return redirect()->route('artiste.dashboard');
        } elseif ($user->role === 'sponsor') {
            return redirect()->route('sponsor.dashboard');
        } else {
            // Par défaut : client
            return redirect()->route('client.dashboard');
        }
    }
}