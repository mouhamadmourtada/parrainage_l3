<div>
    <form wire:submit.prevent="verify" class="space-y-4">
        @csrf
        
        <!-- Messages d'erreur généraux -->
        @if($generalError)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span>{{ $generalError }}</span>
        </div>
        @endif

        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="numero_electeur">
                Numéro de carte d'électeur
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ isset($errorMessages['numero_electeur']) ? 'border-red-500' : '' }}" 
                id="numero_electeur" 
                wire:model="numero_electeur" 
                type="text" 
                required>
            @if(isset($errorMessages['numero_electeur']))
                <p class="text-red-500 text-xs italic mt-1">{{ $errorMessages['numero_electeur'][0] ?? '' }}</p>
            @endif
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="cin">
                Numéro de carte d'identité nationale
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ isset($errorMessages['cin']) ? 'border-red-500' : '' }}" 
                id="cin" 
                wire:model="cin" 
                type="text" 
                required>
            @if(isset($errorMessages['cin']))
                <p class="text-red-500 text-xs italic mt-1">{{ $errorMessages['cin'][0] ?? '' }}</p>
            @endif
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">
                Nom de famille
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ isset($errorMessages['nom']) ? 'border-red-500' : '' }}" 
                id="nom" 
                wire:model="nom" 
                type="text" 
                required>
            @if(isset($errorMessages['nom']))
                <p class="text-red-500 text-xs italic mt-1">{{ $errorMessages['nom'][0] ?? '' }}</p>
            @endif
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="bureau_vote">
                Numéro du bureau de vote
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline {{ isset($errorMessages['bureau_vote']) ? 'border-red-500' : '' }}" 
                id="bureau_vote" 
                wire:model="bureau_vote" 
                type="text" 
                required>
            @if(isset($errorMessages['bureau_vote']))
                <p class="text-red-500 text-xs italic mt-1">{{ $errorMessages['bureau_vote'][0] ?? '' }}</p>
            @endif
        </div>
        <div class="flex items-center justify-center">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                type="submit">
                <span wire:loading.remove>Vérifier</span>
                <span wire:loading>Vérification...</span>
            </button>
        </div>
    </form>
</div>
