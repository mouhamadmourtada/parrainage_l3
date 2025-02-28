@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des utilisateurs agents</h1>
        <a href="{{ route('agent_dge.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Ajouter un agent
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
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date création</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="py-3 px-4 bg-gray-100 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($agents as $agent)
                        <tr>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="ml-2">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $agent->user->email }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $agent->telephone }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $agent->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @if($agent->est_actif)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Actif
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-3">
                                    <a href="{{ route('agent_dge.users.show', $agent->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('agent_dge.users.edit', $agent->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($agent->id !== Auth::user()->userable_id || Auth::user()->userable_type !== 'App\\Models\\AgentDGE')
                                        <form method="POST" action="{{ route('agent_dge.users.toggle-status', $agent->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-{{ $agent->est_actif ? 'red' : 'green' }}-600 hover:text-{{ $agent->est_actif ? 'red' : 'green' }}-900 bg-transparent border-0 p-0">
                                                <i class="fas fa-{{ $agent->est_actif ? 'ban' : 'check-circle' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('agent_dge.users.destroy', $agent->id) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border-0 p-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-4 text-center text-gray-500">
                                Aucun agent DGE trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4">
            {{ $agents->links() }}
        </div>
    </div>
    
    <div class="mt-6">
        <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
        </a>
    </div>
</div>
@endsection