@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-center">
        <div class="w-full md:w-3/4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-600 p-4 text-white">
                    <h2 class="text-xl font-bold mb-0">Vérification du Fichier Électoral</h2>
                </div>

                <div class="p-6">
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6">
                        <h5 class="font-bold mb-2">Informations sur le fichier importé</h5>
                        <p class="mb-1">Date d'upload: <strong>{{ $upload->date_upload->format('d/m/Y à H:i:s') }}</strong></p>
                        <p class="mb-1">Checksum SHA256: <strong>{{ $upload->checksum_sha256 }}</strong></p>
                        <p class="mb-1">Nombre total d'électeurs dans le fichier: <strong>{{ $nbElecteurs }}</strong></p>
                    </div>

                    @if($nbProblemes > 0)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                            <h5 class="flex items-center font-bold mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Problèmes détectés
                            </h5>
                            <p class="mb-1">Nombre d'électeurs avec problèmes: <strong>{{ $nbProblemes }}</strong></p>
                            <p class="mb-0">L'importation ne peut pas être validée tant que des problèmes sont présents.</p>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-lg font-semibold mb-3">Liste des problèmes détectés</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">#</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">CIN</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Numéro Électeur</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Nature du Problème</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($electeursProblematiques as $probleme)
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-2">{{ $probleme->probleme_id }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $probleme->cin }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $probleme->numero_electeur }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $probleme->nature_probleme }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="my-4">
                                {{ $electeursProblematiques->links() }}
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('agent_dge.import.form') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Retour à l'importation
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                            <h5 class="flex items-center font-bold mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Aucun problème détecté
                            </h5>
                            <p class="mb-0">Le fichier a passé tous les contrôles avec succès. Vous pouvez maintenant procéder à la validation de l'importation.</p>
                        </div>

                        <form method="POST" action="{{ route('agent_dge.valider', ['upload_id' => $upload->id]) }}" class="mt-6">
                            @csrf
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center" onclick="return confirm('Êtes-vous sûr de vouloir valider cette importation ? Cette action est irréversible.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Valider l'importation
                                </button>
                                <a href="{{ route('agent_dge.import.form') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Annuler
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection