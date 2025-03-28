<?php

use Mary\Traits\Toast;
use App\Models\Feature;
use App\Models\Product;
use Livewire\Volt\Component;
use App\Traits\ManageProduct;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};

new
#[Title('Product creation')]
#[Layout('components.layouts.admin')]
class extends Component
{
    use Toast, ManageProduct, WithFileUploads;

    public $availableFeatures;

    public function mount(): void
    {
        $this->availableFeatures = Feature::all();
    }
    

    public function save(): void
    {
        try {
            $data = $this->validateProductData();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Validation failed: ' . implode(', ', $e->errors()[array_key_first($e->errors())]));
            return;
        }

        if (!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        $data['unique_id'] = \Illuminate\Support\Str::random(10);
        $product = Product::create($data);

        $this->saveFeatures($product);

        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                    $path = $image->store('photos', 'public');
                    $product->images()->create([
                        'image' => basename($path),
                    ]);
                }
            }
        }

        $this->success(__('Product created successfully.'), redirectTo: '/admin/products');
    }

    public function with(): array
    {
        return [
            'availableFeatures' => $this->availableFeatures,
            'existingImages' => collect([]),
        ];
    }
};
?>
<x-form wire:submit="save">
    <!-- Nom du produit -->
    <x-input
        label="{{ __('Name') }}"
        wire:model="name"
        required
        placeholder="{!! __('Enter product name') !!}"
    />

    <!-- Description -->
    <x-textarea
        label="{{ __('Description') }}"
        wire:model="description"
        placeholder="{!! __('Enter product description') !!}"
        rows="5"
        required
    />

    <!-- Caractéristiques -->
    @foreach ($availableFeatures as $feature)
        <x-input
            label="{{ $feature->name }}"
            wire:model="features.{{ $feature->id }}"
            placeholder="Valeur pour {{ $feature->name }}"
        />
    @endforeach

    <!-- Poids -->
    <x-input
        label="{{ __('Weight in kg') }}"
        wire:model="weight"
        required
        type="number"
        step="0.001"
        placeholder="{{ __('Enter product weight') }}"
    />

    <!-- Prix -->
    <x-input
        label="{{ __('Price') }}"
        wire:model="price"
        required
        type="number"
        step="0.01"
        placeholder="{{ __('Enter product price') }}"
    />

    <!-- Quantité disponible -->
    <x-input
        label="{{ __('Quantity available') }}"
        wire:model="quantity"
        type="number"
        required
        placeholder="{{ __('Enter product quantity') }}"
    />

    <!-- Alerte de stock -->
    <x-input
        label="{{ __('Quantity for stock alert') }}"
        wire:model="quantity_alert"
        type="number"
        required
        placeholder="{{ __('Enter product quantity') }}"
    />

    <!-- Produit actif -->
    <x-checkbox
        label="{{ __('Active product') }}"
        wire:model="active"
    />

    <!-- Promotion -->
    <div class="text-red-500">
        <x-checkbox
            label="{{ __('Promotion') }}"
            wire:model="promotion"
            wire:change="$refresh"
        />
    </div>

    <!-- Champs de promotion (conditionnels) -->
    @if ($promotion)
        <x-input
            label="{{ __('Promotion price') }}"
            wire:model="promotion_price"
            type="number"
            step="0.01"
            placeholder="{{ __('Enter product promotion price') }}"
        />

        <x-datetime
            label="{{ __('Promotion start date') }}"
            icon="o-calendar"
            wire:model="promotion_start_date"
            type="date"
        />

        <x-datetime
            label="{{ __('Promotion end date') }}"
            icon="o-calendar"
            wire:model="promotion_end_date"
            type="date"
        />
    @endif

    <hr class="my-4">

    <!-- Gestion des images multiples -->
    <div class="my-4">
        <label class="block text-sm font-medium text-gray-700">{{ __('Images') }}</label>

        <!-- Affichage des images existantes (vide pour la création) -->
        @if($existingImages && $existingImages->isNotEmpty())
            <div class="flex flex-wrap gap-4 mb-4">
                @foreach($existingImages as $image)
                    <div class="relative">
                        <img
                            src="{{ asset('storage/photos/' . $image->image) }}"
                            class="h-40 rounded"
                            alt="{{ __('Product image') }}"
                        >
                        <x-button
                            icon="o-trash"
                            wire:click="$set('images', array_filter($images, fn($img) => $img !== '{{ $image->image }}'))"
                            class="absolute top-0 right-0 text-red-500 btn-ghost btn-sm"
                        />
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('No images yet.') }}</p>
        @endif

        <!-- Champ pour uploader plusieurs images -->
        <input
            type="file"
            wire:model="images"
            multiple
            accept="image/png,image/jpeg,image/jpg,image/gif"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
        />
        <small class="text-gray-500">{!! __('Click to upload multiple images') !!}</small>
    </div>

    <!-- Actions -->
    <x-slot:actions>
        <x-button
            label="{{ __('Save') }}"
            icon="o-paper-airplane"
            spinner="save"
            type="submit"
            class="btn-primary"
        />
    </x-slot:actions>
</x-form>
