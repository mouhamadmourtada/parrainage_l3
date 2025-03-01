@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Liste des candidats</h1>
        <div class="flex space-x-3">
            <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center transition-colors duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Tableau de bord
            </a>
            <a href="{{ route('agent_dge.candidats.recherche') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center transition-colors duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter un candidat
            </a>
        </div>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-4 text-white">
            <h2 class="text-xl font-semibold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Candidats enregistrés
            </h2>
        </div>

        @if($candidats->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($candidats as $candidat)
                    <div class="border rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 bg-white transform hover:-translate-y-1">
                        <div class="relative">
                            <!-- Changement de l'affichage du dégradé de couleurs -->
                            <div class="h-40 relative overflow-hidden">
                                <!-- Bandes de couleur côte à côte plutôt qu'un dégradé -->
                                <div class="absolute inset-0 grid grid-cols-3">
                                    <div class="col-span-1" style="background-color: {{ $candidat->couleur1 }}"></div>
                                    <div class="col-span-1" style="background-color: {{ $candidat->couleur2 }}"></div>
                                    <div class="col-span-1" style="background-color: {{ $candidat->couleur3 }}"></div>
                                </div>
                                <!-- Superposition d'une texture subtile -->
                                <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmIj48L3JlY3Q+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiMwMDAiPjwvcmVjdD4KPC9zdmc+')"></div>
                                
                                <!-- Photo du candidat -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                                        <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->electeur->nom }}" class="h-28 w-28 rounded-full border-4 border-white object-cover shadow-md">
                                    @else
                                        @php
                                            $gender = $candidat->electeur->sexe == 'F' ? 'female' : 'male';
                                            $avatarNumber = abs(crc32($candidat->electeur->nom.$candidat->electeur->prenom)) % 8 + 1;
                                            $avatarUrl = asset('images/avatars/' . $gender . $avatarNumber . '.png');
                                        @endphp
                                        
                                        @if(file_exists(public_path('images/avatars/' . $gender . $avatarNumber . '.png')))
                                            <img src="{{ $avatarUrl }}" alt="{{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}" class="h-28 w-28 rounded-full border-4 border-white object-cover shadow-md">
                                        @else
                                            <div class="h-28 w-28 rounded-full bg-white border-4 border-white flex items-center justify-center shadow-md">
                                                <span class="text-3xl font-bold" style="color: {{ $candidat->couleur1 }}">
                                                    {{ substr($candidat->electeur->prenom, 0, 1) }}{{ substr($candidat->electeur->nom, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <div class="absolute top-2 right-2">
                                <div class="bg-white bg-opacity-80 rounded-full p-1 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="font-bold text-xl text-center text-gray-800 mb-1">
                                {{ $candidat->electeur->prenom }} {{ $candidat->electeur->nom }}
                            </h3>
                            
                            @if($candidat->parti_politique)
                                <p class="text-sm text-center font-medium text-gray-600 mb-2">{{ $candidat->parti_politique }}</p>
                            @endif

                            @if($candidat->slogan)
                                <div class="bg-gray-50 rounded-lg p-3 text-center italic my-3 text-gray-600 border-l-4" style="border-color: {{ $candidat->couleur1 }}">
                                    "{{ $candidat->slogan }}"
                                </div>
                            @endif
                            
                            <hr class="my-4 border-gray-100">
                            
                            <div class="grid grid-cols-1 gap-2 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $candidat->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $candidat->telephone }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $candidat->date_enregistrement->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-5 text-center">
                                <a href="{{ route('agent_dge.candidats.details', $candidat->id) }}" 
                                   class="inline-flex items-center px-4 py-2 rounded-lg text-white font-medium shadow-sm transition-all duration-300"
                                   style="background-color: {{ $candidat->couleur1 }}; hover:opacity-90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-6 border-t border-gray-100">
                {{ $candidats->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center p-12 text-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-xl font-medium mb-2">Aucun candidat n'est encore enregistré.</p>
                <p class="mb-6">Ajoutez votre premier candidat pour commencer.</p>
                <a href="{{ route('agent_dge.candidats.recherche') }}" class="inline-flex items-center px-5 py-2 rounded-lg text-white font-medium bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter un candidat
                </a>
            </div>
        @endif
    </div>
</div>

<script>
    // Ajout d'une subtile animation au survol des boutons
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.transition-all');
        cards.forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            card.addEventListener('mouseout', function() {
                this.style.boxShadow = '';
            });
        });
    });
</script>
@endsection