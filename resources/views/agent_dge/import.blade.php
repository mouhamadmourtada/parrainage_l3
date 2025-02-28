@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-center">
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-600 p-4 text-white">
                    <h2 class="text-xl font-bold mb-0">Importation du Fichier Électoral</h2>
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

                    @if ($etatUpload)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                            <strong class="font-bold">Attention :</strong> Un fichier électoral a déjà été importé et validé. L'importation de nouveaux fichiers est désactivée.
                        </div>
                    @else
                        <form method="POST" action="{{ route('agent_dge.import') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-6">
                                <p class="mb-2">Cette interface vous permet d'importer le fichier électoral au format CSV et de contrôler son contenu.</p>
                                <p class="mb-2">Veuillez suivre les étapes suivantes :</p>
                                <ol class="list-decimal pl-6">
                                    <li class="mb-1">Calculez l'empreinte SHA256 du fichier CSV</li>
                                    <li class="mb-1">Saisissez cette empreinte dans le champ ci-dessous</li>
                                    <li class="mb-1">Sélectionnez le fichier CSV à importer</li>
                                    <li class="mb-1">Cliquez sur "Importer le fichier"</li>
                                </ol>
                            </div>

                            <div class="mb-4">
                                <label for="checksum_sha256" class="block text-gray-700 font-medium mb-2">Empreinte SHA256 du fichier</label>
                                <input type="text" class="w-full px-3 py-2 border rounded-md @error('checksum_sha256') border-red-500 @enderror" id="checksum_sha256" name="checksum_sha256" value="{{ old('checksum_sha256') }}" required>
                                @error('checksum_sha256')
                                    <span class="text-red-500 text-sm mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">
                                    L'empreinte SHA256 permet de vérifier l'intégrité du fichier. Elle doit être calculée en amont.
                                </p>
                            </div>

                            <div class="mb-4">
                                <label for="fichier_csv" class="block text-gray-700 font-medium mb-2">Fichier électoral (CSV)</label>
                                <input type="file" class="w-full px-3 py-2 border rounded-md @error('fichier_csv') border-red-500 @enderror" id="fichier_csv" name="fichier_csv" accept=".csv,.txt" required>
                                @error('fichier_csv')
                                    <span class="text-red-500 text-sm mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <p class="text-gray-500 text-sm mt-1">
                                    Le fichier doit être au format CSV (encodé en UTF-8) et ne pas dépasser 50 MB.
                                </p>
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-upload mr-2"></i> Importer le fichier
                                </button>
                            </div>
                        </form>

                        <div class="mt-6">
                            <h4 class="text-lg font-semibold mb-2">Format attendu du fichier CSV</h4>
                            <p class="mb-2">Le fichier CSV doit contenir les colonnes suivantes :</p>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">CIN</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Numéro Électeur</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Nom</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Prénom</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Date Naissance</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Lieu Naissance</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Sexe</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left bg-gray-100">Bureau Vote</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">1234567890123</td>
                                            <td class="border border-gray-300 px-4 py-2">ELEC123456</td>
                                            <td class="border border-gray-300 px-4 py-2">Diop</td>
                                            <td class="border border-gray-300 px-4 py-2">Mamadou</td>
                                            <td class="border border-gray-300 px-4 py-2">1975-01-15</td>
                                            <td class="border border-gray-300 px-4 py-2">Dakar</td>
                                            <td class="border border-gray-300 px-4 py-2">M</td>
                                            <td class="border border-gray-300 px-4 py-2">Bureau 123</td>
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
@endsection