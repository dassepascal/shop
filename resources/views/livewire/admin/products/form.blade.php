<x-form wire:submit="save">
    <x-input label="{{ __('Name') }}" wire:model="name" required placeholder="{!! __('Enter product name') !!}" />
    <x-textarea label="{{ __('Description') }}" wire:model="description" placeholder="{!! __('Enter product description') !!}" rows="5" required />
    @foreach ($availableFeatures as $feature)
        <x-input label="{{ $feature->name }}" wire:model="features.{{ $feature->id }}" placeholder="Valeur pour {{ $feature->name }}" />
    @endforeach
    <x-input label="{{ __('Weight in kg') }}" wire:model="weight" required type="number" step="0.001" placeholder="{{ __('Enter product weight') }}" />
    <x-input label="{{ __('Price') }}" wire:model="price" required type="number" step="0.01" placeholder="{{ __('Enter product price') }}" />
    <x-input label="{{ __('Quantity available') }}" wire:model="quantity" type="number" required placeholder="{{ __('Enter product quantity') }}" />
    <x-input label="{{ __('Quantity for stock alert') }}" wire:model="quantity_alert" type="number" required placeholder="{{ __('Enter product quantity') }}" />
    <x-checkbox label="{{ __('Active product') }}" wire:model="active" />
    <div class="text-red-500">
        <x-checkbox label="{{ __('Promotion') }}" wire:model="promotion" wire:change="$refresh" />
    </div>
    @if ($promotion)
        <x-input label="{{ __('Promotion price') }}" wire:model="promotion_price" type="number" step="0.01" placeholder="{{ __('Enter product promotion price') }}" />
        <x-datetime label="{{ __('Promotion start date') }}" icon="o-calendar" wire:model="promotion_start_date" type="date" />
        <x-datetime label="{{ __('Promotion end date') }}" icon="o-calendar" wire:model="promotion_end_date" type="date" />
    @endif

    <hr class="my-4">

    <div class="my-4">
        <label class="block text-sm font-medium text-gray-700">{{ __('Images') }}</label>

        @if($existingImages && $existingImages->isNotEmpty())
            <div class="flex flex-wrap gap-4 mb-4" wire:ignore.self>
                @foreach($existingImages as $image)
                    <div class="relative">
                        <img src="{{ asset('storage/photos/' . $image->image) }}" class="h-40 rounded" alt="{{ __('Product image') }}">
                        <x-button
                            icon="o-trash"
                            wire:click="removeImage('{{ $image->image }}')"
                            class="absolute top-0 right-0 text-red-500 btn-ghost btn-sm"
                        />
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('No images yet.') }}</p>
        @endif

        <input
            type="file"
            wire:model="images"
            multiple
            accept="image/png,image/jpeg,image/jpg,image/gif"
            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
        />
        <small class="text-gray-500">{!! __('Click to upload additional images') !!}</small>
    </div>

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
