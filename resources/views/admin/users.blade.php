@extends('layouts.app')

@section('title', 'Gestion des utilisateurs - Negus Family')
@section('header', '👥 Gestion des utilisateurs')

@section('sidebar')
    @include('partials.sidebar-admin', ['active' => 'utilisateurs'])
@endsection

@section('content')
<div class="card-music">
    <h3 class="text-lg font-bold text-white font-title mb-4">Liste des utilisateurs</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b border-[#334155]">
                <tr class="text-left text-[#94A3B8]">
                    <th class="pb-2 font-medium">ID</th>
                    <th class="pb-2 font-medium">Nom</th>
                    <th class="pb-2 font-medium">Email</th>
                    <th class="pb-2 font-medium">Rôle</th>
                    <th class="pb-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-[#334155]/50 hover:bg-[#1E293B] transition">
                    <td class="py-3 text-white">{{ $user->id }}</td>
                    <td class="py-3 text-white">{{ $user->nom }}</td>
                    <td class="py-3 text-[#94A3B8]">{{ $user->email }}</td>
                    <td class="py-3">
                        <span class="badge-gold">{{ $user->role }}</span>
                    </td>
                    <td class="py-3 text-right">
                        <button class="text-[#94A3B8] hover:text-[#D4AF37] transition mr-2">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                        <button class="text-[#94A3B8] hover:text-blue-400 transition mr-2">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                        <button class="text-[#94A3B8] hover:text-red-400 transition">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection