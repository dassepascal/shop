<?php

use Mary\Traits\Toast;
use App\Models\Feature;
use App\Models\Product;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public array $sortBy = [
        'column'    => 'name',
        'direction' => 'asc',
    ];

    public int $perPage = 10;
    public $availableFeatures; // Propriété publique

    public function mount(): void
    {
        $this->availableFeatures = Feature::all(); // Initialisation
    }
    public function headers(): array
    {
        return [
            ['key' => 'images', 'label' => __('Images')],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'price', 'label' => __('Price incl. VAT'), 'class' => 'text-right'],
            ['key' => 'active', 'label' => __('Active'), 'class' => 'text-center'],
            ['key' => 'promotion_price', 'label' => __('Promotion'), 'class' => 'text-right'],
            ['key' => 'quantity', 'label' => __('Quantity'), 'class' => 'text-right'],
        ];
    }

    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);

        // Supprimer les images associées dans ProductImages
        $product->images()->delete();

        // Supprimer le produit lui-même
        $product->delete();

        $this->success(__('Product deleted successfully.'));
        $this->resetPage();
    }

    public function updated($property): void
    {
        if (! is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function with(): array
    {


        return [
            'products' => Product::with('features','images') // Charger les caractéristiques
                ->orderBy(...array_values($this->sortBy))
                ->paginate($this->perPage),
            'headers' => $this->headers(),
           'availableFeatures' => $this->availableFeatures,
        ];
    }
}; ?>

@section('title', __('Catalog'))
<div>
    <x-header title="{{ __('Catalog') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
            <x-button icon="o-currency-euro" label="{!! __('Global promotion') !!}" link="/admin/products/promotion" spinner class="btn-success" />
            <x-button icon="o-plus" label="{!! __('Create a new product') !!}" link="/admin/products/create" spinner class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$products" :sort-by="$sortBy" per-page="perPage" with-pagination
            link="/admin/products/{id}/edit">
            @scope('cell_images', $product)
            @if ($product->images->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach ($product->images as $image)
                @if ($image->image)
                <img src="{{ asset('storage/photos/' . $image->image) }}"
                    width="60"
                    alt="{{ $product->title }} - Image"
                    class="rounded">
                @endif
                @endforeach
            </div>
            @else
            <img src="{{ asset('images/ask.png') }}"
                width="60"
                alt="Image par défaut">
            @endif
            @endscope

            @scope('cell_price', $product)
            {{ ftA($product->price) }}
            @endscope

            @scope('cell_active', $product)
            @if ($product->active)
            <x-icon name="o-check-circle" class='text-green-400 w-7' />
            @else
            <x-icon name="o-x-circle" class='text-orange-400 w-7' />
            @endif
            @endscope


            @scope('cell_quantity', $product)
            @if($product->quantity < $product->quantity_alert)
                <x-badge class="p-3 my-4 badge-error" value="{{ bigR($product->quantity, 0) }}" />
                @else
                {{ bigR($product->quantity, 0) }}
                @endif
                @endscope

                @scope('cell_promotion_price', $product)
                @if($product->promotion_price)
                @if(now()->isBefore($product->promotion_start_date))
                <x-badge class="p-3 my-4 badge-info" value="{{ trans('Coming soon') }}" />
                @elseif(now()->between($product->promotion_start_date, $product->promotion_end_date))
                <x-badge class="p-3 my-4 badge-success" value="{{ trans('In promotion') }}" />
                @else
                <x-badge class="p-3 my-4 badge-error" value="{{ trans('Expired') }}" />
                @endIf
                <span class="{{ now()->between($product->promotion_start_date, $product->promotion_end_date) ? 'text-red-500' : ''}} ml-2">
                    {{ $product->promotion_price }} €
                </span>
                <br>
                <span class="whitespace-nowrap">
                    {{ $product->promotion_start_date->isoFormat('LL') }} - {{ $product->promotion_end_date->isoFormat('LL') }}
                </span>
                @endif
                @endscope

                @scope('actions', $product)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteProduct({{ $product->id ?? ''}})"
                            wire:confirm="{{ __('Are you sure you want to delete this product?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
                @endscope
        </x-table>
    </x-card>
</div>
