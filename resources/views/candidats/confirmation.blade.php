@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-4 px-6 bg-green-500 text-white text-center">
            <h1 class="text-2xl font-bold">Enregistrement réussi !</h1>
            <p class="mt-1 text-sm">La candidature a été enregistrée avec succès</p>
        </div>

        <div class="py-6 px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col items-center justify-center">
                <div class="w-32 h-32 bg-gray-200 rounded-full overflow-hidden mb-4">
                    @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                        <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->electeur->nom }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600">
                            <span class="text-3xl font-bold">
                                {{ substr($candidat->electeur->prenom, 0, 1) }}{{ substr($candidat->electeur->nom, 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
                
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}
                </h2>
                
                @if($candidat->parti_politique)
                    <p class="text-gray-600 mt-1">{{ $candidat->parti_politique }}</p>
                @endif
                
                <div class="flex space-x-2 mt-2">
                    <div class="w-8 h-8 rounded-full border border-gray-300" style="background-color: {{ $candidat->couleur1 }}"></div>
                    <div class="w-8 h-8 rounded-full border border-gray-300" style="background-color: {{ $candidat->couleur2 }}"></div>
                    <div class="w-8 h-8 rounded-full border border-gray-300" style="background-color: {{ $candidat->couleur3 }}"></div>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-800 mb-2">Informations de contact</h3>
                <p class="text-sm text-gray-700 mb-2">
                    <strong>Email :</strong> {{ $candidat->email }}
                </p>
                <p class="text-sm text-gray-700 mb-2">
                    <strong>Téléphone :</strong> {{ $candidat->telephone }}
                </p>
                <p class="text-sm text-gray-700">
                    Un code de sécurité a été envoyé à l'adresse email et au numéro de téléphone du candidat.
                </p>
            </div>

            <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-semibold text-yellow-800 mb-2">Code de sécurité</h3>
                <p class="text-sm text-gray-700">
                    Le code de sécurité généré est : <strong>{{ $candidat->code_securite }}</strong>
                </p>
                <p class="text-xs text-gray-600 mt-2">
                    Note : Ce code ne sera plus visible après avoir quitté cette page.
                </p>
            </div>

            <div class="mt-6 flex justify-center space-x-4">
                <a href="{{ route('agent_dge.candidats.liste') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline">
                    Voir tous les candidats
                </a>
                <a href="{{ route('agent_dge.candidats.recherche') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline">
                    Ajouter un autre candidat
                </a>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('agent_dge.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>
@endsection