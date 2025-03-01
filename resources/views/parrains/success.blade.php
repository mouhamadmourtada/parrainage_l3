@extends('layouts.app')

@section('title', 'Compte activé avec succès')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-green-600 to-green-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Activation réussie</h2>
                <p class="text-sm text-green-100 mt-1">Votre compte a été créé et activé avec succès</p>
            </div>
            
            <div class="p-6">
                <div class="flex justify-center mb-8">
                    <div class="bg-green-100 rounded-full p-4">
                        <svg class="h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Félicitations!</h3>
                    <p class="text-gray-600">Votre compte a été créé et activé avec succès. Conservez précieusement vos identifiants de connexion.</p>
                </div>
                
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                    <h4 class="font-semibold text-lg text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Vos identifiants de connexion
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-600 mb-1">Identifiant</p>
                            <div class="flex items-center justify-between">
                                <p class="font-mono text-blue-700 font-medium">{{ session('username') }}</p>
                                <button onclick="copyToClipboard('{{ session('username') }}')" class="text-gray-500 hover:text-blue-600 transition" title="Copier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-600 mb-1">Mot de passe</p>
                            <div class="flex items-center justify-between">
                                <p class="font-mono text-blue-700 font-medium">{{ session('password') }}</p>
                                <button onclick="copyToClipboard('{{ session('password') }}')" class="text-gray-500 hover:text-blue-600 transition" title="Copier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-800">
                                Ces informations ont également été envoyées à votre adresse email et par SMS.
                                <strong>Conservez-les précieusement.</strong>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('parrainage.authentification') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center transition-colors duration-200 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Se connecter maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
    
    // Afficher une notification (optionnel)
    alert('Copié dans le presse-papiers!');
}
</script>
@endsection
