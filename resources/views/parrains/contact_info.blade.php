@extends('layouts.app')

@section('title', 'Informations de contact')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                <h2 class="text-xl font-bold mb-0">Complétez vos informations</h2>
                <p class="text-sm text-blue-100 mt-1">Ces informations nous permettront de vous contacter</p>
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
                
                @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif
                
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6">
                    <p class="font-medium">Informations importantes</p>
                    <p class="text-sm mt-1">Ces données sont nécessaires pour vérifier votre identité et vous permettre de participer au processus de parrainage.</p>
                </div>
                
                <form action="{{ route('parrain.save-contact') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="prenom">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('prenom') border-red-500 @enderror" 
                                id="prenom" 
                                name="prenom" 
                                type="text" 
                                value="{{ old('prenom') }}"
                                required>
                            @error('prenom')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="date_naissance">
                                Date de naissance <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('date_naissance') border-red-500 @enderror" 
                                id="date_naissance" 
                                name="date_naissance" 
                                type="date" 
                                value="{{ old('date_naissance') }}"
                                required>
                            @error('date_naissance')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="lieu_naissance">
                                Lieu de naissance <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('lieu_naissance') border-red-500 @enderror" 
                                id="lieu_naissance" 
                                name="lieu_naissance" 
                                type="text" 
                                value="{{ old('lieu_naissance') }}"
                                required>
                            @error('lieu_naissance')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="sexe">
                                Sexe <span class="text-red-500">*</span>
                            </label>
                            <select class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('sexe') border-red-500 @enderror" 
                                id="sexe" 
                                name="sexe" 
                                required>
                                <option value="">Sélectionnez</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('sexe')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="telephone">
                                Numéro de téléphone <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-0 top-0 bg-gray-100 flex items-center justify-center h-full px-3 border border-r-0 border-gray-300 rounded-l-md text-gray-600">+221</span>
                                <input class="pl-16 shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('telephone') border-red-500 @enderror" 
                                    id="telephone" 
                                    name="telephone" 
                                    type="tel" 
                                    placeholder="7X XXX XX XX"
                                    value="{{ old('telephone') }}"
                                    required
                                    x-data="{}"
                                    x-mask="7 99 999 99 99">
                            </div>
                            @error('telephone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                                Adresse email <span class="text-red-500">*</span>
                            </label>
                            <input class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror" 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 mt-8 pt-6">
                        <div class="flex items-center justify-between">
                            <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Retour
                                </div>
                            </a>
                            
                            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md inline-flex items-center transition-colors duration-200 shadow-md" 
                                type="submit">
                                Enregistrer
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
@endpush
