@extends('layouts.app')

@section('title', 'Compte activé avec succès')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="text-center">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <svg class="mx-auto h-12 w-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="font-bold">Succès</p>
                <p>Votre compte a été créé et activé avec succès!</p>
            </div>
            
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Identifiants de connexion</h2>
            
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <p class="mb-2">
                    <span class="font-semibold">Identifiant :</span> 
                    <span class="text-blue-600">{{ session('username') }}</span>
                </p>
                <p>
                    <span class="font-semibold">Mot de passe :</span> 
                    <span class="text-blue-600">{{ session('password') }}</span>
                </p>
            </div>
            
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-3 rounded mb-6">
                <p>
                    Ces informations ont également été envoyées à votre adresse email et par SMS.
                    <br>
                    <span class="font-bold">Veuillez les conserver précieusement.</span>
                </p>
            </div>
            
            <a 
                href = "{{ route('parrainage.authentification') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block">
                Se connecter
            </a>
        </div>
    </div>
</div>
@endsection
