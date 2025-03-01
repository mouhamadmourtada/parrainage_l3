@extends('layouts.app')

@section('title', 'Activation de compte parrain')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Activation de compte parrain</h2>
                <p class="text-sm text-blue-100 mt-1">Première étape pour participer au processus de parrainage</p>
            </div>
            
            <div class="p-6">
                <!-- Le composant Livewire pour le formulaire d'activation -->
                @livewire('parrain-activation-form')
                
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
