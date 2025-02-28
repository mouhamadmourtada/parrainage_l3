@extends('layouts.app')

@section('title', 'Dashboard Agent DGE')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-soft overflow-hidden">
        <div class="py-4 px-6 bg-primary-600 text-white">
            <h2 class="text-xl font-bold">Dashboard Agent DGE</h2>
        </div>

        <div class="p-6">
            <!-- Première rangée de cartes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Gestion du fichier électoral -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Gestion du fichier électoral</h3>
                        <p class="text-gray-600 mb-4">Importation et vérification du fichier électoral.</p>
                        <a href="{{ route('agent_dge.import') }}" class="btn-primary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Importer un fichier électoral
                        </a>
                    </div>
                </div>
                
                <!-- Historique des imports -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Historique des imports</h3>
                        <p class="text-gray-600 mb-4">Consulter l'historique des tentatives d'import.</p>
                        <a href="{{ route('agent_dge.historique-uploads') }}" class="btn-primary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Voir l'historique
                        </a>
                    </div>
                </div>
                
                <!-- Gestion des candidats -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Gestion des candidats</h3>
                        <p class="text-gray-600 mb-4">Gérer les candidats et leurs informations.</p>
                        <a href="{{ route('agent_dge.candidats.liste') }}" class="btn-primary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Liste des candidats
                        </a>
                    </div>
                </div>
            </div>

            <!-- Deuxième rangée de cartes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Ajouter un candidat -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Ajouter un candidat</h3>
                        <p class="text-gray-600 mb-4">Inscrire un nouveau candidat au parrainage.</p>
                        <a href="{{ route('agent_dge.candidats.recherche') }}" class="btn-primary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Nouveau candidat
                        </a>
                    </div>
                </div>
                
                <!-- Gestion des utilisateurs -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Gestion des utilisateurs</h3>
                        <p class="text-gray-600 mb-4">Gérer les agents DGE et leurs accès.</p>
                        <a href="{{ route('agent_dge.users.index') }}" class="btn-primary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Agents DGE
                        </a>
                    </div>
                </div>
                
                <!-- Statistiques -->
                <div class="bg-white rounded-lg shadow-soft overflow-hidden border border-gray-100">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Statistiques</h3>
                        <p class="text-gray-600 mb-4">Consulter les statistiques du fichier électoral.</p>
                        <a href="#" class="btn-secondary inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Voir les statistiques
                        </a>
                    </div>
                </div>
            </div>

            <!-- État du système -->
            <div class="mt-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">État du système</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-sm">
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-left text-sm font-medium text-gray-700 w-2/5">
                                    État de l'importation du fichier électoral
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        $etatUpload = DB::select("SELECT @EtatUploadElecteurs AS etat")[0]->etat ?? false;
                                    @endphp
                                    
                                    @if($etatUpload)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                        <span class="text-sm text-gray-500 ml-2">Un fichier électoral a déjà été importé et validé.</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                        <span class="text-sm text-gray-500 ml-2">Aucun fichier électoral n'a encore été validé.</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                    Nombre d'électeurs enregistrés
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        use App\Models\Electeur;
                                        $nbElecteurs = Electeur::count();
                                    @endphp
                                    <span class="font-semibold">{{ number_format($nbElecteurs, 0, ',', ' ') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                    Nombre de candidats enregistrés
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        use App\Models\Candidat;
                                        $nbCandidats = Candidat::count();
                                    @endphp
                                    <span class="font-semibold">{{ number_format($nbCandidats, 0, ',', ' ') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                    Dernière tentative d'import
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        use App\Models\HistoriqueUpload;
                                        $dernierUpload = HistoriqueUpload::latest('date_upload')->first();
                                    @endphp
                                    
                                    @if($dernierUpload)
                                        <div class="font-medium">{{ $dernierUpload->date_upload->format('d/m/Y H:i:s') }}</div>
                                        <div class="flex items-center mt-1">
                                            @if($dernierUpload->est_succes)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Réussi</span>
                                            @elseif($dernierUpload->message_erreur)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Erreur</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                            @endif
                                            <a href="{{ route('agent_dge.verification', ['upload_id' => $dernierUpload->id]) }}" class="ml-3 text-sm text-primary-600 hover:underline">
                                                Voir les détails
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">Aucun import n'a été effectué</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-left text-sm font-medium text-gray-700">
                                    Nombre d'agents DGE
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @php
                                        use App\Models\AgentDGE;
                                        $nbAgents = AgentDGE::count();
                                        $nbAgentsActifs = AgentDGE::all()->count();
                                    @endphp
                                    <span class="font-semibold">{{ $nbAgentsActifs }}</span> actifs / {{ $nbAgents }} au total
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection