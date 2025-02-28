@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Recherche d'un candidat</h1>
            <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Retour
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="py-4 px-6 bg-blue-500 text-white text-center">
                <h2 class="text-xl font-bold">Enregistrement de candidature</h2>
                <p class="mt-1 text-sm">Veuillez saisir le numéro d'électeur du candidat pour commencer</p>
            </div>

            <div class="py-6 px-8">
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('agent_dge.candidats.verifier') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="numero_electeur" class="block text-gray-700 text-sm font-bold mb-2">
                            Numéro d'électeur
                        </label>
                        <input type="text" 
                               name="numero_electeur" 
                               id="numero_electeur" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('numero_electeur') border-red-500 @enderror" 
                               placeholder="Entrez le numéro d'électeur du candidat" 
                               value="{{ old('numero_electeur') }}" 
                               required 
                               autofocus>
                        
                        @error('numero_electeur')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Vérifier et continuer
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="py-3 px-8 bg-gray-100 border-t border-gray-200">
                <p class="text-xs text-center text-gray-500">
                    Pour enregistrer un candidat, il doit être présent dans le fichier électoral.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection