@extends('layouts.app')

@section('title', 'Confirmation du parrainage')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Confirmation de votre parrainage</h2>
                <p class="text-sm text-blue-100 mt-1">Dernière étape avant la validation</p>
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
                
                <div class="bg-blue-50 border border-blue-200 text-blue-700 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Vous avez choisi de parrainer :</p>
                            <p class="font-bold text-lg text-blue-800 mt-1">{{ $candidat['candidat_prenom'] }} {{ $candidat['candidat_nom'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                    <h3 class="font-bold text-lg mb-3 text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Confirmation finale
                    </h3>
                    
                    <p class="text-gray-600 mb-4">
                        Un code de confirmation à 5 chiffres vous a été envoyé par email à l'adresse associée à votre compte.
                        <br>Veuillez saisir ce code pour confirmer définitivement votre parrainage.
                    </p>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 text-yellow-700 text-sm mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p>
                                    Attention : cette action est définitive et ne pourra pas être modifiée.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('parrainage.confirmer') }}" method="POST" class="mt-6">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="code_confirmation">
                                Code de confirmation (5 chiffres) <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm border border-gray-300 rounded-md w-full py-3 px-3 text-gray-700 text-center text-2xl tracking-widest font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('code_confirmation') border-red-500 @enderror" 
                                id="code_confirmation" 
                                name="code_confirmation" 
                                type="text" 
                                pattern="[0-9]{5}"
                                maxlength="5"
                                placeholder="•••••"
                                value="{{ old('code_confirmation') }}"
                                required
                                x-data="{}"
                                x-mask="99999">
                            @error('code_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('parrainage.candidats') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Retour au choix des candidats
                            </a>
                            
                            <button class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center transition-colors duration-200 shadow-md" 
                                type="submit">
                                Confirmer mon parrainage
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
@endpush