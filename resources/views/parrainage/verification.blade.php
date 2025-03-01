@extends('layouts.app')

@section('title', 'Vérification d\'électeur')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Vérification d'identité</h2>
                <p class="text-sm text-blue-100 mt-1">Première étape pour le processus de parrainage</p>
            </div>
            
            <div class="p-6">
                @if($errors->has('general'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-medium">{{ $errors->first('general') }}</p>
                    </div>
                </div>
                @endif
                
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6">
                    <p class="font-medium">Information</p>
                    <p class="text-sm mt-1">Pour pouvoir parrainer un candidat, veuillez d'abord vérifier votre identité en renseignant les informations de votre carte d'électeur.</p>
                </div>
                
                <form action="{{ route('parrainage.verifier') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="numero_electeur">
                            Numéro de carte d'électeur <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <input class="pl-10 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('numero_electeur') border-red-500 @enderror" 
                                id="numero_electeur" 
                                name="numero_electeur" 
                                type="text" 
                                placeholder="Ex: ELEC123456789"
                                value="{{ old('numero_electeur') }}"
                                required>
                        </div>
                        @error('numero_electeur')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="cin">
                            Numéro de carte d'identité nationale <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                </svg>
                            </div>
                            <input class="pl-10 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('cin') border-red-500 @enderror" 
                                id="cin" 
                                name="cin" 
                                type="text" 
                                placeholder="Ex: 1234567890123"
                                value="{{ old('cin') }}"
                                required>
                        </div>
                        @error('cin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="pt-4">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md flex justify-center items-center transition-colors duration-200 shadow-md" 
                            type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Vérifier mon identité
                        </button>
                    </div>
                </form>
                
                <!-- Lien de retour -->
                <div class="mt-6 text-center">
                    <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center justify-center">
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