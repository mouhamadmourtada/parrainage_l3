@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Liste des candidats</h1>
        <a href="{{ route('agent_dge.candidats.recherche') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Ajouter un candidat
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
        @if($candidats->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                @foreach($candidats as $candidat)
                    <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="h-32 bg-gray-200 relative" style="background: linear-gradient(135deg, {{ $candidat->couleur1 }} 0%, {{ $candidat->couleur2 }} 50%, {{ $candidat->couleur3 }} 100%);">
                            <div class="absolute inset-0 flex items-center justify-center">
                                @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                                    <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->electeur->nom }}" class="h-24 w-24 rounded-full border-4 border-white object-cover">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gray-300 border-4 border-white flex items-center justify-center">
                                        <span class="text-2xl font-bold text-gray-600">
                                            {{ substr($candidat->electeur->prenom, 0, 1) }}{{ substr($candidat->electeur->nom, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-bold text-lg text-center">
                                {{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}
                            </h3>
                            
                            @if($candidat->parti_politique)
                                <p class="text-sm text-center text-gray-600 mb-2">{{ $candidat->parti_politique }}</p>
                            @endif

                            @if($candidat->slogan)
                                <p class="text-sm text-center italic mb-3">"{{ $candidat->slogan }}"</p>
                            @endif
                            
                            <hr class="my-3">
                            
                            <div class="mt-2 text-sm text-gray-600">
                                <p><strong>Email:</strong> {{ $candidat->email }}</p>
                                <p><strong>Téléphone:</strong> {{ $candidat->telephone }}</p>
                                <p><strong>Date d'inscription:</strong> {{ $candidat->date_enregistrement->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="mt-4 flex justify-center">
                                <a href="{{ route('agent_dge.candidats.details', $candidat->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t">
                {{ $candidats->links() }}
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">Aucun candidat n'est encore enregistré.</p>
                <p class="mt-2">Cliquez sur "Ajouter un candidat" pour commencer.</p>
            </div>
        @endif
    </div>
    
    <div class="mt-6">
        <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour au tableau de bord
        </a>
    </div>
</div>
@endsection