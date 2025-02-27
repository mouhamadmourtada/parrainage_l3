@extends('layouts.app')

@section('title', 'Activation de compte parrain')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Activation de compte parrain</h2>
        
        <form id="verification-form" class="space-y-4">
            @csrf
            
            <!-- Messages d'erreur généraux -->
            <div id="error-container" class="hidden">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span id="error-message"></span>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_electeur">
                    Numéro de carte d'électeur
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="numero_electeur" 
                    name="numero_electeur" 
                    type="text" 
                    required>
                <p class="text-red-500 text-xs italic mt-1 hidden" id="numero_electeur-error"></p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cin">
                    Numéro de carte d'identité nationale
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="cin" 
                    name="cin" 
                    type="text" 
                    required>
                <p class="text-red-500 text-xs italic mt-1 hidden" id="cin-error"></p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">
                    Nom de famille
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="nom" 
                    name="nom" 
                    type="text" 
                    required>
                <p class="text-red-500 text-xs italic mt-1 hidden" id="nom-error"></p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bureau_vote">
                    Numéro du bureau de vote
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    id="bureau_vote" 
                    name="bureau_vote" 
                    type="text" 
                    required>
                <p class="text-red-500 text-xs italic mt-1 hidden" id="bureau_vote-error"></p>
            </div>

            <div class="flex items-center justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                    type="submit">
                    Vérifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#verification-form').on('submit', function(e) {
        e.preventDefault();
        
        // Réinitialiser tous les messages d'erreur
        $('#error-container').addClass('hidden');
        $('.text-red-500').addClass('hidden').html('');
        $('input').removeClass('border-red-500');
        
        $.ajax({
            url: '{{ route("parrain.verify") }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                window.location.href = '{{ route("parrain.contact") }}';
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                
                if (errors) {
                    // Afficher les erreurs spécifiques aux champs
                    for (let field in errors) {
                        if (field === 'general') {
                            $('#error-message').html(errors[field].join('<br>'));
                            $('#error-container').removeClass('hidden');
                        } else {
                            $(`#${field}-error`)
                                .html(errors[field].join('<br>'))
                                .removeClass('hidden');
                            $(`#${field}`).addClass('border-red-500');
                        }
                    }
                } else {
                    // Afficher une erreur générale si aucune erreur spécifique n'est retournée
                    $('#error-message').html('Une erreur est survenue. Veuillez réessayer.');
                    $('#error-container').removeClass('hidden');
                }
            }
        });
    });
});
</script>
@endpush
