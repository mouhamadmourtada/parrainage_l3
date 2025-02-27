@extends('layouts.app')

@section('title', 'Authentification d\'électeur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Authentification</h2>
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold text-lg mb-2">Informations de l'électeur</h3>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <p class="text-sm text-gray-600">Nom:</p>
                    <p class="font-semibold">{{ $electeur['nom'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Prénom:</p>
                    <p class="font-semibold">{{ $electeur['prenom'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date de naissance:</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($electeur['date_naissance'])->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Bureau de vote:</p>
                    <p class="font-semibold">{{ $electeur['bureau_vote'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-600">
                Veuillez saisir votre code d'authentification pour continuer.
                <br>Ce code vous a été envoyé par email lors de votre inscription sur la plateforme.
            </p>
        </div>
        
        <form action="{{ route('parrainage.authentifier') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="code_authentification">
                    Code d'authentification
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('code_authentification') border-red-500 @enderror" 
                    id="code_authentification" 
                    name="code_authentification" 
                    type="text" 
                    value="{{ old('code_authentification') }}"
                    required>
                @error('code_authentification')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('parrainage.verification') }}" class="text-blue-500 hover:text-blue-700">
                    Retour
                </a>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Continuer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection