<?php

use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    #[Rule('required|string|min:3|max:255')] // aquí se define la regla de validate() para $message
    public $message = '';

    public function store(): void
    {
        $validated = $this->validate();
        // dd($validated);

        auth()->user()->chirps()->create($validated);

        $this->message = '';

        $this->dispatch('chirp-created'); // enviar un evento cada vez que se crea un chirp (se recibe desde list de livewire)
    }
}; ?>

<div>
    <form wire:submit="store">
        <textarea
            required
            wire:model="message"
            placeholder="{{ __('What\'s on your mind?') }}"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>
        <x-input-error :messages="$errors->get('message')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Chirp') }}</x-primary-button>
    </form>
</div>
