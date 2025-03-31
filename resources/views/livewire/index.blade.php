<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public string $group = ''; // Propriété pour l'accordéon

    // Propriétés pour les filtres de recherche
    public string $searchDiameter = '';
    public string $searchSkin = '';
    public string $searchColor = '';
    public string $searchMaterial = '';

    public function with(): array
    {
        $query = Product::whereActive(true)->with(['images', 'features']);

        // Appliquer les filtres si les champs ne sont pas vides
        if ($this->searchDiameter) {
            $query->whereHas('features', function ($q) {
                $q->where('name', 'like', '%diamètre%')
                  ->where('value', 'like', '%' . $this->searchDiameter . '%');
            });
        }
        if ($this->searchSkin) {
            $query->whereHas('features', function ($q) {
                $q->where('name', 'like', '%peau%')
                  ->where('value', 'like', '%' . $this->searchSkin . '%');
            });
        }
        if ($this->searchColor) {
            $query->whereHas('features', function ($q) {
                $q->where('name', 'like', '%couleur%')
                  ->where('value', 'like', '%' . $this->searchColor . '%');
            });
        }
        if ($this->searchMaterial) {
            $query->whereHas('features', function ($q) {
                $q->where('name', 'like', '%matière%')
                  ->where('value', 'like', '%' . $this->searchMaterial . '%');
            });
        }

        return [
            'products' => $query->get(),
        ];
    }

    // Méthode pour réinitialiser les filtres
    public function resetFilters(): void
    {
        $this->searchDiameter = '';
        $this->searchSkin = '';
        $this->searchColor = '';
        $this->searchMaterial = '';
    }
};
?>

<div class="container mx-auto">
    @if (session('registered'))
        <x-alert title="{!! session('registered') !!}" icon="s-rocket-launch" class="mb-4 alert-info" dismissible />
    @endif
    <x-card class="w-full shadow-md shadow-gray-500" shadow separator>
        {!! $shop->home !!}
    </x-card>

    <!-- Barre de recherche avec filtres horizontaux et bouton Reset aligné -->
    <div class="mt-4 mb-6 flex flex-wrap gap-4 items-end">
        <x-input
            wire:model.live="searchDiameter"
            label="{{ __('Diameter') }}"
            placeholder="{{ __('Filter by diameter') }}"
            class="flex-1 min-w-[150px]"
        />
        <x-input
            wire:model.live="searchSkin"
            label="{{ __('Skin') }}"
            placeholder="{{ __('Filter by skin') }}"
            class="flex-1 min-w-[150px]"
        />
        <x-input
            wire:model.live="searchColor"
            label="{{ __('Color') }}"
            placeholder="{{ __('Filter by color') }}"
            class="flex-1 min-w-[150px]"
        />
        <x-input
            wire:model.live="searchMaterial"
            label="{{ __('Material') }}"
            placeholder="{{ __('Filter by material') }}"
            class="flex-1 min-w-[150px]"
        />
        <x-button wire:click="resetFilters" class="btn-secondary" icon="o-x-mark">{{ __('Reset') }}</x-button>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($products as $product)
            @php
            $bestPrice = getBestPrice($product);
            $hasPromotion = $bestPrice < $product->price;
            if ($hasPromotion) {
                $titleContent = '<span class="line-through">' . number_format($product->price, 2, ',', ' ') . ' € TTC</span> <span class="text-red-500">' . number_format($bestPrice, 2, ',', ' ') . ' € TTC</span>';
            } else {
                $titleContent = '<span>' . number_format($product->price, 2, ',', ' ') . ' € TTC</span>';
            }
            $firstImage = $product->images->first()?->image ?? 'ask.png'; // Première image ou image par défaut
            @endphp
            <x-card class="shadow-md transition duration-500 ease-in-out shadow-gray-500 hover:shadow-xl hover:shadow-gray-500 flex flex-col justify-between relative">
                <b>{!! $product->name !!} :</b>
                {!! $titleContent !!}<br>

                @unless ($product->quantity)
                    <br><span class="text-red-500">@lang('Product out of stock')</span>
                @endunless

                <x-slot:figure>
                    <div class="relative group">
                        @if ($product->quantity)
                            <a href="{{ route('products.show', $product) }}" class="block">
                                <img src="{{ asset('storage/photos/' . $firstImage) }}" alt="{!! $product->name !!}" class="w-full object-cover" />
                            </a>
                        @else
                            <img src="{{ asset('storage/photos/' . $firstImage) }}" alt="{!! $product->name !!}" class="w-full object-cover" />
                        @endif

                        <!-- Conteneur pour les caractéristiques avec titre, affiché au survol -->
                        @if($product->features->isNotEmpty())
                            <div class="absolute inset-0 bg-black bg-opacity-75 text-white p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center pointer-events-none">
                                <h3 class="text-lg font-semibold mb-2">{{ __('Features') }}</h3>
                                <ul class="list-disc list-inside text-sm">
                                    @foreach($product->features as $feature)
                                        <li>{{ $feature->name }} : {{ $feature->pivot->value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </x-slot:figure>
            </x-card>
        @endforeach
    </div>
    <br>
    <x-card class="w-full shadow-md shadow-gray-500" shadow separator>
        <x-accordion wire:model="group" class="shadow-md shadow-gray-500">
            <x-collapse name="group1">
                <x-slot:heading>{{ __('General informations') }}</x-slot:heading>
                <x-slot:content>{!! $shop->home_infos !!}</x-slot:content>
            </x-collapse>
            <x-collapse name="group2">
                <x-slot:heading>{{ __('Shipping charges') }}</x-slot:heading>
                <x-slot:content>{!! $shop->home_shipping !!}</x-slot:content>
            </x-collapse>
        </x-accordion>
    </x-card>
</div>
