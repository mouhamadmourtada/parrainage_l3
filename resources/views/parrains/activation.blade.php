@extends('layouts.app')

@section('title', 'Activation de compte parrain')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Activation de compte parrain</h2>
        
        @livewire('parrain-activation-form')
    </div>
</div>
@endsection
