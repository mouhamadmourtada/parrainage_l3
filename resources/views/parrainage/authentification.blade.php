@extends('layouts.app')

@section('title', 'Authentification d\'électeur')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Authentification</h2>
                <p class="text-sm text-blue-100 mt-1">Accéder au processus de parrainage</p>
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
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                    <h3 class="font-bold text-lg mb-3 text-gray-800">Informations de l'électeur</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <p class="text-sm text-gray-600">Nom</p>
                            <p class="font-semibold text-gray-800">{{ $electeur['nom'] }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm text-gray-600">Prénom</p>
                            <p class="font-semibold text-gray-800">{{ $electeur['prenom'] }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm text-gray-600">Date de naissance</p>
                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($electeur['date_naissance'])->format('d/m/Y') }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm text-gray-600">Bureau de vote</p>
                            <p class="font-semibold text-gray-800">{{ $electeur['bureau_vote'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6">
                    <p class="font-medium">Étape d'authentification</p>
                    <p class="text-sm mt-1">Veuillez saisir votre code d'authentification pour continuer. Ce code vous a été envoyé par email lors de votre inscription sur la plateforme.</p>
                </div>
                
                <form action="{{ route('parrainage.authentifier') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="code_authentification">
                            Code d'authentification <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input class="pl-10 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('code_authentification') border-red-500 @enderror" 
                                id="code_authentification" 
                                name="code_authentification" 
                                type="text" 
                                placeholder="Saisissez votre code ici"
                                value="{{ old('code_authentification') }}"
                                required>
                        </div>
                        @error('code_authentification')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('parrainage.verification') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Retour
                        </a>
                        
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center transition-colors duration-200 shadow-md" 
                            type="submit">
                            Continuer
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection