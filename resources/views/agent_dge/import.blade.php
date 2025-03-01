@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Importation du Fichier Électoral</h1>
        <a href="{{ route('agent_dge.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center transition duration-150 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour au Tableau de Bord
        </a>
    </div>

    <div class="flex justify-center">
        <div class="w-full md:w-3/4 lg:w-2/3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-700 to-blue-500 p-5 text-white">
                    <h2 class="text-xl font-bold mb-0">Importation du Fichier Électoral</h2>
                    <p class="text-sm text-blue-100 mt-1">Suivez les instructions ci-dessous pour importer correctement le fichier électoral</p>
                </div>

                <div class="p-6">
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-md shadow-sm">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-md shadow-sm">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($etatUpload)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-r-md shadow-sm">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <strong class="font-bold mr-1">Attention :</strong> Un fichier électoral a déjà été importé et validé. L'importation de nouveaux fichiers est désactivée.
                            </div>
                        </div>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6 rounded-r-md">
                            <h3 class="font-bold mb-2">Instructions d'importation</h3>
                            <ol class="list-decimal pl-6 space-y-2">
                                <li>Calculez l'empreinte SHA256 du fichier CSV</li>
                                <li>Saisissez cette empreinte dans le champ ci-dessous</li>
                                <li>Sélectionnez le fichier CSV à importer</li>
                                <li>Cliquez sur "Importer le fichier"</li>
                            </ol>
                        </div>

                        <form method="POST" action="{{ route('agent_dge.import') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label for="checksum_sha256" class="block text-gray-700 font-medium mb-2">
                                    Empreinte SHA256 du fichier
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('checksum_sha256') border-red-500 @enderror" id="checksum_sha256" name="checksum_sha256" value="{{ old('checksum_sha256') }}" required>
                                @error('checksum_sha256')
                                    <span class="text-red-500 text-sm mt-1 block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    L'empreinte SHA256 permet de vérifier l'intégrité du fichier. Elle doit être calculée en amont.
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label for="fichier_csv" class="block text-gray-700 font-medium mb-2">
                                    Fichier électoral (CSV)
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition duration-150 ease-in-out">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="fichier_csv" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Sélectionner un fichier</span>
                                                <input id="fichier_csv" name="fichier_csv" type="file" class="sr-only" accept=".csv,.txt" required>
                                            </label>
                                            <p class="pl-1">ou glisser-déposer</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            CSV uniquement (max. 50MB)
                                        </p>
                                    </div>
                                </div>
                                <div id="selected-file" class="mt-2 text-sm text-gray-500 hidden">
                                    Fichier sélectionné: <span class="font-medium"></span>
                                </div>
                                @error('fichier_csv')
                                    <span class="text-red-500 text-sm mt-1 block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <p class="text-gray-500 text-sm mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Le fichier doit être au format CSV (encodé en UTF-8) et ne pas dépasser 50 MB.
                                </p>
                            </div>

                            <div class="flex justify-center">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md inline-flex items-center transition duration-150 ease-in-out shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                    Importer le fichier
                                </button>
                            </div>
                        </form>

                        <div class="mt-10">
                            <h4 class="text-lg font-semibold mb-3 border-b pb-2">Format attendu du fichier CSV</h4>
                            <p class="mb-3">Le fichier CSV doit contenir les colonnes suivantes :</p>
                            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro Électeur</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Naissance</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu Naissance</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sexe</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bureau Vote</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">1234567890123</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">ELEC123456</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Diop</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Mamadou</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">1975-01-15</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Dakar</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">M</td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Bureau 123</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fichier_csv');
    const selectedFile = document.getElementById('selected-file');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                selectedFile.classList.remove('hidden');
                selectedFile.querySelector('span').textContent = fileInput.files[0].name;
            } else {
                selectedFile.classList.add('hidden');
            }
        });
    }
});
</script>
@endsection