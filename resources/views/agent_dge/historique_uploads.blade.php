@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Historique des importations de fichiers électoraux</h1>
    
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

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Date</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Agent DGE</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Adresse IP</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Nombre d'électeurs</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Problèmes</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Statut</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($uploads as $upload)
                        <tr>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $upload->date_upload->format('d/m/Y H:i:s') }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $upload->agentDge->nom }} {{ $upload->agentDge->prenom }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $upload->adresse_ip }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">{{ $upload->nb_electeurs }}</td>
                            <td class="py-2 px-4 whitespace-nowrap">
                                @if($upload->nb_problemes > 0)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                                        {{ $upload->nb_problemes }} problèmes
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        Aucun problème
                                    </span>
                                @endif
                            </td>
                            <td class="py-2 px-4 whitespace-nowrap">
                                @if($upload->est_succes)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                        Validé
                                    </span>
                                @else
                                    @if($upload->message_erreur)
                                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                                            Erreur
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                                            En attente
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="py-2 px-4 whitespace-nowrap">
                                <a 
                                {{-- href="{{ route('agent_dge.verification', ['upload_id' => $upload->id]) }}"  --}}
                                   class="text-blue-600 hover:text-blue-900">
                                    Voir détails
                                </a>
                                @if(!$upload->est_succes && $upload->nb_problemes == 0 && !$upload->message_erreur)
                                    <form 
                                    {{-- action="{{ route('agent_dge.valider-importation', ['upload_id' => $upload->id]) }}"  --}}
                                          method="POST" class="inline-block ml-2">
                                        @csrf
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900">
                                            Valider
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @if($upload->message_erreur)
                            <tr>
                                <td colspan="7" class="py-2 px-4 bg-red-50 text-red-700 text-sm">
                                    <strong>Erreur:</strong> {{ $upload->message_erreur }}
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">
                                Aucun historique d'importation disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $uploads->links() }}
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Retour au tableau de bord
        </a>
        <a href="{{ route('agent_dge.import') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
            Importer un nouveau fichier
        </a>
    </div>
</div>
@endsection