@extends('layouts.app')

@section('title', 'Choix du candidat')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Choix du candidat à parrainer</h2>
                <p class="text-sm text-blue-100 mt-1">Sélectionnez un candidat auquel apporter votre soutien</p>
            </div>
            
            <div class="p-6">
                @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <ul class="list-disc ml-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Information importante</p>
                            <p class="text-sm mt-1">Sélectionnez un candidat pour lequel vous souhaitez apporter votre parrainage.
                            Vous ne pourrez parrainer qu'un seul candidat pour cette élection. Ce choix est définitif.</p>
                        </div>
                    </div>
                </div>
                
                @if(count($candidats) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($candidats as $candidat)
                        <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="h-48 relative overflow-hidden">
                                @if($candidat->photo_url && Storage::disk('public')->exists($candidat->photo_url))
                                    <img src="{{ asset('storage/' . $candidat->photo_url) }}" alt="{{ $candidat->prenom }} {{ $candidat->nom }}" class="object-cover w-full h-full">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        @php
                                            $gender = isset($candidat->electeur) && $candidat->electeur->sexe == 'F' ? 'female' : 'male';
                                            $avatarNumber = abs(crc32($candidat->nom.$candidat->prenom)) % 8 + 1;
                                            $avatarUrl = asset('images/avatars/' . $gender . $avatarNumber . '.png');
                                        @endphp
                                        
                                        @if(file_exists(public_path('images/avatars/' . $gender . $avatarNumber . '.png')))
                                            <img src="{{ $avatarUrl }}" alt="{{ $candidat->prenom }} {{ $candidat->nom }}" class="object-cover w-full h-full">
                                        @else
                                            <span class="text-4xl font-bold text-gray-400">
                                                {{ substr($candidat->prenom, 0, 1) }}{{ substr($candidat->nom, 0, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Bannière colorée -->
                                <div class="absolute bottom-0 left-0 w-full h-1/5">
                                    <div class="grid grid-cols-3 h-full">
                                        <div style="background-color: {{ $candidat->couleur1 ?? '#4B5563' }}"></div>
                                        <div style="background-color: {{ $candidat->couleur2 ?? '#6B7280' }}"></div>
                                        <div style="background-color: {{ $candidat->couleur3 ?? '#9CA3AF' }}"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <h3 class="font-bold text-xl text-gray-800 mb-1">{{ $candidat->prenom }} {{ $candidat->nom }}</h3>
                                
                                @if($candidat->parti_politique)
                                    <p class="text-sm text-gray-600 mb-3">{{ $candidat->parti_politique }}</p>
                                @endif
                                
                                @if($candidat->slogan)
                                    <div class="bg-gray-50 rounded-lg p-3 text-center italic my-3 text-gray-600 border-l-4" style="border-color: {{ $candidat->couleur1 ?? '#4B5563' }}">
                                        "{{ $candidat->slogan }}"
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-center mt-4 mb-3">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                        Parrains: {{ $candidat->nombre_parrains ?? 0 }}
                                    </span>
                                </div>
                                
                                <form action="{{ route('parrainage.choisir.candidat') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                                    
                                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md flex justify-center items-center transition-colors duration-200 shadow-md" 
                                        type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Choisir ce candidat
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-xl font-medium text-gray-700 mb-2">Aucun candidat n'est disponible</p>
                        <p class="text-gray-500">Aucun candidat n'est actuellement disponible pour le parrainage.</p>
                    </div>
                @endif
                
                <div class="mt-8 text-center">
                    <a href="{{ route('parrainage.authentification') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à l'authentification
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Animation au survol des cartes
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.hover\\:shadow-lg');
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