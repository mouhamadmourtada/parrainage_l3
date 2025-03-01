@extends('layouts.app')

@section('title', 'Espace Candidat - Connexion')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-md mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-purple-700 to-purple-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Espace Candidat</h2>
                <p class="text-sm text-purple-100 mt-1">Suivez l'évolution de vos parrainages</p>
            </div>
            
            <div class="p-6">
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
                
                <div class="bg-purple-50 border-l-4 border-purple-400 text-purple-700 p-4 mb-6">
                    <p class="font-medium">Accès réservé aux candidats</p>
                    <p class="text-sm mt-1">Veuillez vous connecter avec votre adresse email et le code d'authentification qui vous a été fourni lors de votre enregistrement.</p>
                </div>
                
                <form action="{{ route('candidat.authenticate') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input class="pl-10 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('email') border-red-500 @enderror" 
                                id="email" 
                                name="email" 
                                type="email" 
                                placeholder="votre-email@exemple.com"
                                value="{{ old('email') }}"
                                required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="code_securite">
                            Code d'authentification <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input class="pl-10 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('code_securite') border-red-500 @enderror" 
                                id="code_securite" 
                                name="code_securite" 
                                type="text" 
                                placeholder="Code à 8 caractères"
                                required>
                        </div>
                        @error('code_securite')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="pt-4">
                        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-6 rounded-md flex justify-center items-center transition-colors duration-200 shadow-md" 
                            type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Se connecter
                        </button>
                    </div>
                </form>
                
                <!-- Lien de retour -->
                <div class="mt-6 text-center">
                    <a href="{{ url('/') }}" class="text-purple-600 hover:text-purple-800 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la page d'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection