@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Inscription d'un candidat</h1>
        <a href="{{ route('agent_dge.candidats.recherche') }}" class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>
    
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="py-4 px-6 bg-blue-500 text-white text-center">
            <h2 class="text-xl font-bold">Inscription de candidature</h2>
            <p class="mt-1 text-sm">Saisissez les informations complémentaires pour finaliser la candidature</p>
        </div>

        <div class="py-6 px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 bg-gray-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations du fichier électoral</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Numéro d'électeur :</p>
                        <p class="font-medium">{{ $electeur->numero_electeur }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">CIN :</p>
                        <p class="font-medium">{{ $electeur->cin }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nom :</p>
                        <p class="font-medium">{{ $electeur->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Prénom :</p>
                        <p class="font-medium">{{ $electeur->prenom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date de naissance :</p>
                        <p class="font-medium">{{ $electeur->date_naissance->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Lieu de naissance :</p>
                        <p class="font-medium">{{ $electeur->lieu_naissance }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('agent_dge.candidats.inscription') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="numero_electeur" value="{{ $electeur->numero_electeur }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            Adresse email *
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                               placeholder="email@exemple.com" 
                               value="{{ old('email') }}" 
                               required>
                        
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telephone" class="block text-gray-700 text-sm font-bold mb-2">
                            Numéro de téléphone *
                        </label>
                        <input type="text" 
                               name="telephone" 
                               id="telephone" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('telephone') border-red-500 @enderror" 
                               placeholder="+221 XX XXX XX XX" 
                               value="{{ old('telephone') }}" 
                               required>
                        
                        @error('telephone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parti_politique" class="block text-gray-700 text-sm font-bold mb-2">
                            Parti politique
                        </label>
                        <input type="text" 
                               name="parti_politique" 
                               id="parti_politique" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               placeholder="Nom du parti politique (optionnel)" 
                               value="{{ old('parti_politique') }}">
                    </div>

                    <div>
                        <label for="slogan" class="block text-gray-700 text-sm font-bold mb-2">
                            Slogan
                        </label>
                        <input type="text" 
                               name="slogan" 
                               id="slogan" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               placeholder="Slogan de campagne (optionnel)" 
                               value="{{ old('slogan') }}">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="photo" class="block text-gray-700 text-sm font-bold mb-2">
                        Photo du candidat *
                    </label>
                    <input type="file" 
                           name="photo" 
                           id="photo" 
                           class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight @error('photo') border-red-500 @enderror" 
                           accept="image/*" 
                           required>
                    
                    @error('photo')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Format JPG, PNG ou GIF. Taille maximale : 2 Mo.</p>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Couleurs du parti (3) *
                    </label>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <input type="color" 
                                   name="couleur1" 
                                   id="couleur1" 
                                   class="h-10 w-full" 
                                   value="{{ old('couleur1', '#0000FF') }}">
                            <label for="couleur1" class="block text-center text-sm text-gray-600 mt-1">Couleur 1</label>
                        </div>
                        <div>
                            <input type="color" 
                                   name="couleur2" 
                                   id="couleur2" 
                                   class="h-10 w-full" 
                                   value="{{ old('couleur2', '#FFFFFF') }}">
                            <label for="couleur2" class="block text-center text-sm text-gray-600 mt-1">Couleur 2</label>
                        </div>
                        <div>
                            <input type="color" 
                                   name="couleur3" 
                                   id="couleur3" 
                                   class="h-10 w-full" 
                                   value="{{ old('couleur3', '#FF0000') }}">
                            <label for="couleur3" class="block text-center text-sm text-gray-600 mt-1">Couleur 3</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="url_page" class="block text-gray-700 text-sm font-bold mb-2">
                        URL vers la page d'information
                    </label>
                    <input type="url" 
                           name="url_page" 
                           id="url_page" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('url_page') border-red-500 @enderror" 
                           placeholder="https://exemple.com" 
                           value="{{ old('url_page') }}">
                    
                    @error('url_page')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline">
                        Enregistrer le candidat
                    </button>
                </div>
            </form>
        </div>
        
        <div class="py-3 px-8 bg-gray-100 border-t border-gray-200">
            <p class="text-xs text-center text-gray-500">
                * Champs obligatoires. Un code de sécurité sera envoyé à l'email et au téléphone du candidat.
            </p>
        </div>
    </div>
</div>
@endsection