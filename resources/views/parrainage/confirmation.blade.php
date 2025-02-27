@extends('layouts.app')

@section('title', 'Confirmation du parrainage')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Confirmation de votre choix</h2>
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded mb-6">
            <p>Vous avez choisi de parrainer :</p>
            <p class="font-bold text-lg">{{ $candidat['candidat_prenom'] }} {{ $candidat['candidat_nom'] }}</p>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-600">
                Un code de confirmation à 5 chiffres vous a été envoyé par email à l'adresse associée à votre compte.
                <br>Veuillez saisir ce code pour confirmer votre parrainage.
            </p>
        </div>
        
        <form action="{{ route('parrainage.confirmer') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="code_confirmation">
                    Code de confirmation (5 chiffres)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-center text-xl @error('code_confirmation') border-red-500 @enderror" 
                    id="code_confirmation" 
                    name="code_confirmation" 
                    type="text" 
                    pattern="[0-9]{5}"
                    maxlength="5"
                    placeholder="12345"
                    value="{{ old('code_confirmation') }}"
                    required
                    x-data="{}"
                    x-mask="99999">
                @error('code_confirmation')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('parrainage.candidats') }}" class="text-blue-500 hover:text-blue-700">
                    Retour au choix des candidats
                </a>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Confirmer mon parrainage
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Attention : cette action est définitive et ne pourra pas être modifiée.
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
@endpush