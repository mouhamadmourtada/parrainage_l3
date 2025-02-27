@extends('layouts.app')

@section('title', 'Vérification d\'électeur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Vérification d'identité</h2>
        
        @if($errors->has('general'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <p class="font-bold">Erreur</p>
            <p>{{ $errors->first('general') }}</p>
        </div>
        @endif
        
        <div class="mb-6">
            <p class="text-gray-600">
                Pour pouvoir parrainer un candidat, veuillez d'abord vérifier votre identité en renseignant 
                les informations de votre carte d'électeur.
            </p>
        </div>
        
        <form action="{{ route('parrainage.verifier') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_electeur">
                    Numéro de carte d'électeur
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('numero_electeur') border-red-500 @enderror" 
                    id="numero_electeur" 
                    name="numero_electeur" 
                    type="text" 
                    value="{{ old('numero_electeur') }}"
                    required>
                @error('numero_electeur')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cin">
                    Numéro de carte d'identité nationale
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cin') border-red-500 @enderror" 
                    id="cin" 
                    name="cin" 
                    type="text" 
                    value="{{ old('cin') }}"
                    required>
                @error('cin')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-center mt-6">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Vérifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection