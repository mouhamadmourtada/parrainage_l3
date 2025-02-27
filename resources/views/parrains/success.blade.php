@extends('layouts.app')

@section('title', 'Compte activé avec succès')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Compte activé avec succès !</h2>
            
            <p class="text-gray-600 mb-6">
                Votre compte a été créé et activé avec succès. Vous pouvez maintenant vous connecter avec les identifiants suivants :
            </p>
            
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
            
            <p class="text-gray-600 mb-6">
                Ces informations ont également été envoyées à votre adresse email et par SMS.
                <br>
                Veuillez les conserver précieusement.
            </p>
            
            <a href="{{ route('login') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block">
                Se connecter
            </a>
        </div>
    </div>
</div>
@endsection
