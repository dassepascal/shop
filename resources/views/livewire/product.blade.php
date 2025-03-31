<?php

use Livewire\Volt\Component;
use App\Models\Product;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Product $product;
    public int $quantity = 1;
    public bool $hasPromotion = false;
    public float $bestPrice = 0;

    public function mount(Product $product): void
    {
        if (!$product->active) {
            abort(404);
        }

        // Charger le produit avec ses caractéristiques et images
        $this->product = $product->load(['features', 'images']);

        $this->bestPrice = getBestPrice($product);
        $this->hasPromotion = $this->bestPrice < $product->price;
    }

    public function save(): void
    {
        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->bestPrice,
            'quantity' => $this->quantity,
            'attributes' => ['image' => $this->product->images->first()?->image ?? 'ask.png'], // Première image pour le panier
            'associatedModel' => $this->product,
        ]);

        $this->dispatch('cart-updated');

        $this->info(__('Product added to cart.'), position: 'bottom-end');
    }
};
?>

<div class="container p-5 mx-auto ">
    <div class="grid gap-10 lg:grid-cols-2">
        <div>
            <!-- Carrousel d'images -->
            @if($product->images->isNotEmpty())
                <div class="relative w-full overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" id="carousel-{{ $product->id }}">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/photos/' . $image->image) }}" alt="{{ $product->name }}" class="w-full max-h-96 object-cover flex-shrink-0 rounded" />
                        @endforeach
                    </div>
                    <!-- Boutons de navigation -->
                    @if($product->images->count() > 1)
                        <button class="absolute left-0 p-2 text-white transform -translate-y-1/2 bg-gray-800 bg-opacity-50 top-1/2" onclick="prevSlide('carousel-{{ $product->id }}')"><</button>
                        <button class="absolute right-0 p-2 text-white transform -translate-y-1/2 bg-gray-800 bg-opacity-50 top-1/2" onclick="nextSlide('carousel-{{ $product->id }}')">></button>
                    @endif
                </div>
            @else
                <img class="mx-auto" src="{{ asset('images/ask.png') }}" alt="No image available" />
            @endif

            <!-- Bloc des caractéristiques -->
            @if($product->features->isNotEmpty())
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">{{ __('Features') }}</h3>
                    <ul class="list-disc list-inside">
                        @foreach($product->features as $feature)
                            <li>{{ $feature->name }} : {{ $feature->pivot->value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div>
            <div class="text-2xl font-bold">{{ $product->name }}</div>

            @if($hasPromotion)
                <div class="flex items-center space-x-2">
                    <x-badge class="p-3 my-4 badge-neutral line-through" value="{{ number_format($product->price, 2, ',', ' ') . ' € TTC' }}" />
                    <x-badge class="p-3 my-4 badge-error" value="{{ number_format($bestPrice, 2, ',', ' ') . ' € TTC' }}" />
                </div>
            @else
                <x-badge class="p-3 my-4 badge-neutral" value="{{ number_format($product->price, 2, ',', ' ') . ' € TTC' }}" />
            @endif

            <p class="mb-4">{{ $product->description }}</p>
            <x-input class="!w-[80px]" wire:model="quantity" type="number" min="1" label="{{ __('Quantity')}}" />
            <x-button class="mt-4 btn-primary" wire:click="save" icon="o-shopping-cart" spinner>{{ __('Add to cart')}}</x-button>
        </div>
    </div>
</div>

<script>
    function nextSlide(carouselId) {
        const carousel = document.getElementById(carouselId);
        const totalImages = carousel.children.length;
        let currentIndex = parseInt(carousel.dataset.index || 0);
        currentIndex = (currentIndex + 1) % totalImages;
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        carousel.dataset.index = currentIndex;
    }

    function prevSlide(carouselId) {
        const carousel = document.getElementById(carouselId);
        const totalImages = carousel.children.length;
        let currentIndex = parseInt(carousel.dataset.index || 0);
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        carousel.dataset.index = currentIndex;
    }
</script>
