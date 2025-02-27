@extends('layouts.app')

@section('title', 'Informations de contact')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Complétez vos informations</h2>
        
        <form action="{{ route('parrain.save-contact') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">
                    Prénom
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('prenom') border-red-500 @enderror" 
                    id="prenom" 
                    name="prenom" 
                    type="text" 
                    value="{{ old('prenom') }}"
                    required>
                @error('prenom')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_naissance">
                    Date de naissance
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('date_naissance') border-red-500 @enderror" 
                    id="date_naissance" 
                    name="date_naissance" 
                    type="date" 
                    value="{{ old('date_naissance') }}"
                    required>
                @error('date_naissance')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="lieu_naissance">
                    Lieu de naissance
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('lieu_naissance') border-red-500 @enderror" 
                    id="lieu_naissance" 
                    name="lieu_naissance" 
                    type="text" 
                    value="{{ old('lieu_naissance') }}"
                    required>
                @error('lieu_naissance')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sexe">
                    Sexe
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('sexe') border-red-500 @enderror" 
                    id="sexe" 
                    name="sexe" 
                    required>
                    <option value="">Sélectionnez</option>
                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                </select>
                @error('sexe')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="telephone">
                    Numéro de téléphone
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telephone') border-red-500 @enderror" 
                    id="telephone" 
                    name="telephone" 
                    type="tel" 
                    placeholder="7XXXXXXXX"
                    value="{{ old('telephone') }}"
                    required>
                @error('telephone')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Adresse email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                    id="email" 
                    name="email" 
                    type="email" 
                    value="{{ old('email') }}"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
