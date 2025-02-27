@extends('layouts.app')

@section('title', 'Choix du candidat')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Choisissez un candidat à parrainer</h2>
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="mb-6">
            <p class="text-gray-600 text-center">
                Sélectionnez un candidat pour lequel vous souhaitez apporter votre parrainage.
                <br>Vous ne pourrez parrainer qu'un seul candidat pour cette élection.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($candidats as $candidat)
            <div class="border rounded-lg overflow-hidden shadow-lg">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($candidat->photo_url)
                    <img src="{{ $candidat->photo_url }}" alt="{{ $candidat->prenom }} {{ $candidat->nom }}" class="object-cover w-full h-full">
                    @else
                    <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-xl mb-2">{{ $candidat->prenom }} {{ $candidat->nom }}</h3>
                    
                    @if($candidat->slogan)
                    <p class="text-gray-700 italic mb-3">"{{ $candidat->slogan }}"</p>
                    @endif
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600 text-sm">Parrains: {{ $candidat->nombre_parrains }}</span>
                    </div>
                    
                    <form action="{{ route('parrainage.choisir.candidat') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                        
                        <button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                            Choisir ce candidat
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        
        @if(count($candidats) == 0)
        <div class="text-center py-10">
            <p class="text-gray-600">Aucun candidat n'est disponible pour le parrainage actuellement.</p>
        </div>
        @endif
        
        <div class="mt-8 flex justify-center">
            <a href="{{ route('parrainage.authentification') }}" class="text-blue-500 hover:text-blue-700">
                Retour
            </a>
        </div>
    </div>
</div>
@endsection