@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails du candidat</h1>
        <a href="{{ route('agent_dge.candidats.liste') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- En-tête avec les couleurs du parti politique -->
        <div class="h-48 relative" style="background: linear-gradient(135deg, {{ $candidat->couleur1 }} 0%, {{ $candidat->couleur2 }} 50%, {{ $candidat->couleur3 }} 100%);">
            <div class="absolute inset-0 flex items-center justify-center">
                @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                    <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->electeur->nom }}" class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-lg">
                @else
                    <div class="h-32 w-32 rounded-full bg-gray-300 border-4 border-white flex items-center justify-center shadow-lg">
                        <span class="text-3xl font-bold text-gray-600">
                            {{ substr($candidat->electeur->prenom, 0, 1) }}{{ substr($candidat->electeur->nom, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}
                </h2>
                
                @if($candidat->parti_politique)
                    <p class="text-gray-600 mt-1 text-lg">{{ $candidat->parti_politique }}</p>
                @endif

                @if($candidat->slogan)
                    <p class="text-gray-600 mt-2 italic">"{{ $candidat->slogan }}"</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informations personnelles -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 pb-2 border-b border-gray-200">Informations personnelles</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Numéro d'électeur:</span>
                            <span>{{ $candidat->numero_electeur }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">CIN:</span>
                            <span>{{ $candidat->electeur->cin }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Date de naissance:</span>
                            <span>{{ $candidat->electeur->date_naissance->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Lieu de naissance:</span>
                            <span>{{ $candidat->electeur->lieu_naissance }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Bureau de vote:</span>
                            <span>{{ $candidat->electeur->bureau_vote }}</span>
                        </div>
                    </div>
                </div>

                <!-- Informations de contact -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 pb-2 border-b border-gray-200">Informations de contact</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-600">Email:</span>
                            <span>{{ $candidat->email }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-600">Téléphone:</span>
                            <span>{{ $candidat->telephone }}</span>
                        </div>
                        @if($candidat->url_page)
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600">Page web:</span>
                                <a href="{{ $candidat->url_page }}" target="_blank" class="text-blue-500 hover:underline">{{ $candidat->url_page }}</a>
                            </div>
                        @endif
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-600">Date d'inscription:</span>
                            <span>{{ $candidat->date_enregistrement->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section sécurité et authentification -->
            <div class="mt-8 bg-blue-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-3 pb-2 border-b border-blue-200">Sécurité et authentification</h3>
                
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-700">
                            <span class="font-medium">Dernier code généré le:</span> 
                            {{ $candidat->updated_at->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Le code de sécurité permet au candidat de s'authentifier sur la plateforme.
                        </p>
                    </div>
                    
                    <form action="{{ route('agent_dge.candidats.generer-code', $candidat->id) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Générer nouveau code
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Statistiques de parrainage (à compléter plus tard) -->
            <div class="mt-8 bg-green-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-3 pb-2 border-b border-green-200">Statistiques de parrainage</h3>
                
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-700">
                            <span class="font-medium">Nombre de parrainages:</span> 
                            {{ $candidat->parrains->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('agent_dge.candidats.liste') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
        <a href="{{ route('agent_dge.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-home mr-2"></i> Tableau de bord
        </a>
    </div>
</div>
@endsection