<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public string $name = '';
    public string $firstname = '';
    public string $email = '';
    public string $subject = ''; // Contiendra le HTML généré par TinyMCE

    public array $rules = [
        'name' => 'required|string|max:255',
        'firstname' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string', // Pas de limite stricte pour le contenu enrichi
    ];

    public function submit(): void
    {
        $this->validate();

        // Logique pour traiter le formulaire (ex. envoyer un email)
        $this->success('Votre demande a été envoyée avec succès !', position: 'bottom-end');

        // Réinitialiser le formulaire après soumission
        $this->reset(['name', 'firstname', 'email', 'subject']);
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }
}; ?>

<div class="container mx-auto p-5">
    <x-card class="w-full shadow-md shadow-gray-500" shadow separator>
        <h1 class="text-2xl font-bold mb-6">{{ __('Contactez-nous') }}</h1>

        <form wire:submit="submit">
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Nom -->
                <x-input 
                    wire:model="name" 
                    label="{{ __('Nom') }}" 
                    placeholder="{{ __('Entrez votre nom') }}" 
                    required 
                />
                <!-- Prénom -->
                <x-input 
                    wire:model="firstname" 
                    label="{{ __('Prénom') }}" 
                    placeholder="{{ __('Entrez votre prénom') }}" 
                    required 
                />
                <!-- Email -->
                <x-input 
                    wire:model="email" 
                    type="email" 
                    label="{{ __('Email') }}" 
                    placeholder="{{ __('Entrez votre email') }}" 
                    required 
                />
            </div>
            <!-- Objet de la demande avec TinyMCE -->
            <div class="mt-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('Objet de la demande') }}</label>
                <x-editor 
                    id="subject-editor" 
                    wire:model.debounce.500ms="subject" 
                    class="w-full border-gray-300 rounded-md shadow-sm"
                >{{ $subject }}</x-editor>
                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mt-6">
                <x-button 
                    type="submit" 
                    class="btn-primary" 
                    icon="o-paper-airplane" 
                    spinner
                >
                    {{ __('Envoyer') }}
                </x-button>
            </div>
        </form>
    </x-card>
</div>