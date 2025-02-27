@extends('layouts.app')

@section('title', 'Parrainage réussi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="text-center">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <svg class="mx-auto h-12 w-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="font-bold">Parrainage effectué avec succès</p>
                <p>Votre choix a bien été enregistré!</p>
            </div>
            
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Récapitulatif du parrainage</h2>
            
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <div class="mb-4">
                    <span class="font-semibold">Vous avez parrainé :</span> 
                    <span class="text-blue-600 font-bold">{{ $candidat['candidat_prenom'] }} {{ $candidat['candidat_nom'] }}</span>
                </div>
                
                <div>
                    <span class="font-semibold">Électeur :</span> 
                    <span>{{ $electeur['prenom'] }} {{ $electeur['nom'] }}</span>
                </div>
            </div>
            
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-3 rounded mb-6">
                <p>
                    Un email de confirmation vous a été envoyé à l'adresse {{ $electeur['email'] }}.
                    <br>
                    <span class="font-bold">Conservez cette confirmation comme preuve de votre parrainage.</span>
                </p>
            </div>
            
            <a href="{{ route('parrainage.verification') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline inline-block">
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection