@extends('layouts.app')

@section('title', 'Tableau de Bord Candidat')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête du tableau de bord -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-700 to-purple-500 p-6 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="mr-4">
                            @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                                <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->electeur->nom }}" class="h-20 w-20 rounded-full border-4 border-white object-cover shadow-md">
                            @else
                                <div class="h-20 w-20 rounded-full bg-white border-4 border-white flex items-center justify-center shadow-md">
                                    <span class="text-3xl font-bold" style="color: {{ $candidat->couleur1 }}">
                                        {{ substr($candidat->electeur->prenom, 0, 1) }}{{ substr($candidat->electeur->nom, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold mb-1">{{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}</h1>
                            <p class="text-purple-100">{{ $candidat->parti_politique ?: 'Candidat indépendant' }}</p>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('candidat.logout') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-md px-4 py-2 text-sm font-medium flex items-center transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques principales -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-blue-100 mb-1">Total parrains</p>
                                <h3 class="text-3xl font-bold">{{ $stats['totalParrains'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-center">
                                <span class="text-sm text-blue-100">{{ number_format(($stats['totalParrains'] ?? 0) / 7000 * 100, 1) }}% de l'objectif</span>
                                <span class="ml-auto text-xs text-blue-100">Objectif: 7000</span>
                            </div>
                            <div class="w-full bg-blue-700 bg-opacity-50 rounded-full h-2 mt-1">
                                <div class="bg-white h-2 rounded-full" style="width: {{ min((($stats['totalParrains'] ?? 0) / 7000) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-green-100 mb-1">7 derniers jours</p>
                                <h3 class="text-3xl font-bold">{{ $stats['parrainsRecents'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-purple-100 mb-1">Aujourd'hui</p>
                                <h3 class="text-3xl font-bold">{{ $stats['parrainsAujourdhui'] ?? 0 }}</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Graphique d'évolution des parrainages -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="border-b border-gray-200 p-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Évolution des parrainages
                    </h2>
                </div>
                <div class="p-4">
                    <div class="h-72">
                        <canvas id="evolutionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Graphique de répartition par région -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="border-b border-gray-200 p-4">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Répartition par région
                    </h2>
                </div>
                <div class="p-4">
                    <div class="h-72">
                        <canvas id="regionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Derniers parrains -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
            <div class="border-b border-gray-200 p-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Derniers parrainages
                </h2>
            </div>
            <div class="p-4">
                @if(isset($derniersParrains) && count($derniersParrains) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro électeur</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Région</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bureau de vote</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($derniersParrains as $parrain)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $parrain->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ substr($parrain->electeur->numero_electeur, 0, 5) }}•••••••</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $parrain->electeur->region }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $parrain->electeur->bureau_vote }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p>Aucun parrainage n'a encore été enregistré.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Graphique d'évolution des parrainages
document.addEventListener('DOMContentLoaded', function() {
    // Données pour le graphique d'évolution
    const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
    const evolutionChart = new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: @json($graphData['labels'] ?? []),
            datasets: [
                {
                    label: 'Parrainages quotidiens',
                    data: @json($graphData['dailyData'] ?? []),
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                    pointRadius: 2,
                    pointHoverRadius: 4,
                    type: 'bar',
                    order: 2
                },
                {
                    label: 'Total cumulé',
                    data: @json($graphData['cumulativeData'] ?? []),
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                    pointRadius: 0,
                    pointHoverRadius: 3,
                    tension: 0.4,
                    type: 'line',
                    order: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre de parrains'
                    }
                }
            }
        }
    });

    // Graphique de répartition par région
    const regionsCtx = document.getElementById('regionsChart').getContext('2d');
    const regionsChart = new Chart(regionsCtx, {
        type: 'bar',
        data: {
            labels: @json($regionsData['labels'] ?? []),
            datasets: [{
                label: 'Nombre de parrains',
                data: @json($regionsData['data'] ?? []),
                backgroundColor: [
                    'rgba(79, 70, 229, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(109, 40, 217, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(37, 99, 235, 0.8)',
                    'rgba(5, 150, 105, 0.8)',
                    'rgba(217, 119, 6, 0.8)',
                    'rgba(220, 38, 38, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(248, 113, 113, 0.8)',
                    'rgba(6, 182, 212, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ` ${context.parsed.y} parrains`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre de parrains'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Région'
                    }
                }
            }
        }
    });
});
</script>
@endsection
@endsection