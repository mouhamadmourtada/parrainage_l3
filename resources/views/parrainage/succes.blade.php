@extends('layouts.app')

@section('title', 'Parrainage réussi')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-green-600 to-green-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Parrainage effectué avec succès</h2>
                <p class="text-sm text-green-100 mt-1">Votre choix a bien été enregistré</p>
            </div>
            
            <div class="p-6">
                <div class="flex justify-center mb-8">
                    <div class="bg-green-100 rounded-full p-4">
                        <svg class="h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Félicitations !</h3>
                    <p class="text-gray-600">Votre parrainage a été enregistré avec succès. Merci pour votre participation au processus électoral.</p>
                </div>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 mb-6">
                    <h4 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Récapitulatif du parrainage
                    </h4>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-600 mb-1">Candidat parrainé</p>
                            <p class="font-semibold text-blue-800">{{ $candidat['candidat_prenom'] }} {{ $candidat['candidat_nom'] }}</p>
                        </div>
                        
                        <div class="bg-white p-4 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-600 mb-1">Électeur</p>
                            <p class="font-semibold text-gray-800">{{ $electeur['prenom'] }} {{ $electeur['nom'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Un email de confirmation vous a été envoyé à l'adresse <span class="font-semibold">{{ $electeur['email'] }}</span>.<br>
                                <strong>Conservez cette confirmation comme preuve de votre parrainage.</strong>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center border-t border-gray-200 pt-6">
                    <a href="{{ url('/') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center transition-colors duration-200 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection