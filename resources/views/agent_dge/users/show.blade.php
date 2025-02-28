@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails de l'agent DGE</h1>
        <a href="{{ route('agent_dge.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
        <div class="border-b border-gray-200">
            <div class="flex justify-between items-center p-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $agent->prenom }} {{ $agent->nom }}
                </h2>
                
                <div>
                    @if($agent->est_actif)
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Inactif
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations personnelles -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nom complet</p>
                            <p class="mt-1">{{ $agent->prenom }} {{ $agent->nom }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Téléphone</p>
                            <p class="mt-1">{{ $agent->telephone }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de création</p>
                            <p class="mt-1">{{ $agent->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Informations d'authentification -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de connexion</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Adresse email</p>
                            <p class="mt-1">{{ $agent->user->email }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nom d'utilisateur</p>
                            <p class="mt-1">{{ $agent->user->nom_utilisateur }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Dernière connexion</p>
                            <p class="mt-1">{{ $agent->user->derniere_connexion ? $agent->user->derniere_connexion->format('d/m/Y H:i') : 'Jamais connecté' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="mt-8 border-t border-gray-200 pt-6 flex justify-between">
                <div>
                    <a href="{{ route('agent_dge.users.edit', $agent->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                </div>
                
                <div class="flex space-x-4">
                    @if($agent->id !== Auth::user()->userable_id || Auth::user()->userable_type !== 'App\\Models\\AgentDGE')
                        <form method="POST" action="{{ route('agent_dge.users.toggle-status', $agent->id) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-{{ $agent->est_actif ? 'yellow' : 'green' }}-600 hover:bg-{{ $agent->est_actif ? 'yellow' : 'green' }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $agent->est_actif ? 'yellow' : 'green' }}-500">
                                <i class="fas fa-{{ $agent->est_actif ? 'ban' : 'check-circle' }} mr-2"></i>
                                {{ $agent->est_actif ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('agent_dge.users.destroy', $agent->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-2"></i> Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection