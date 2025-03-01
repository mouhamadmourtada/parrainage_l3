<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Agent DGE - Système de Gestion des Parrainages</title>
    
    <!-- Utiliser Vite pour charger les ressources -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-8">
            <img src="https://pbs.twimg.com/media/GbESG-VWcAAO4AK.jpg" alt="Logo DGE" class="w-24 h-24 mx-auto mb-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Direction Générale des Élections</h1>
            <p class="text-xl text-gray-600">Système de Gestion des Parrainages Électoraux</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="py-4 px-6 bg-gradient-to-r from-blue-700 to-blue-500 text-white">
                <h2 class="text-xl font-bold mb-1">Espace Agent DGE</h2>
                <p class="text-sm text-blue-100">Gestion du fichier électoral et contrôle des parrainages</p>
            </div>
            
            <div class="p-6">
                <div class="text-center mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Bienvenue sur votre espace de gestion</h3>
                    <p class="text-gray-600 mb-6">Cet espace sécurisé est destiné aux agents de la Direction Générale des Elections pour la gestion du fichier électoral.</p>
                    
                    @auth
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('agent_dge.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md inline-flex items-center transition-colors duration-300 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Accéder au tableau de bord
                            </a>
                        </div>
                    @else
                        <a href="{{ route('agent_dge.login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md inline-flex items-center transition-colors durée-300 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Connexion
                        </a>
                    @endauth
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition duration-150">
                            <div class="text-5xl text-blue-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Import du fichier électoral</h4>
                            <p class="text-gray-600">Téléchargement et contrôle du fichier CSV des électeurs</p>
                        </div>
                        
                        <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition duration-150">
                            <div class="text-5xl text-blue-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Validation des données</h4>
                            <p class="text-gray-600">Vérification de l'intégrité et de la conformité des données</p>
                        </div>
                        
                        <div class="text-center p-4 hover:bg-gray-50 rounded-lg transition duration-150">
                            <div class="text-5xl text-blue-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Statistiques</h4>
                            <p class="text-gray-600">Suivi et analyse du processus de parrainage</p>
                        </div>
                    </div>
                </div>
                
                @auth
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <div class="bg-blue-50 rounded-lg p-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-800">Vous êtes connecté en tant qu'agent DGE</h4>
                            <p class="text-sm text-gray-600">Accédez à votre tableau de bord pour gérer les candidats et parrainages</p>
                        </div>
                        <a href="{{ route('agent_dge.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Tableau de bord
                        </a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la page d'accueil principale
            </a>
        </div>
    </div>
</body>
</html>