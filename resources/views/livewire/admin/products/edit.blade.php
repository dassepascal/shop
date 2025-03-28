<?php

use Mary\Traits\Toast;
use App\Models\Feature;
use App\Models\Product;
use Livewire\Volt\Component;
use App\Traits\ManageProduct;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

new #[Title('Product edition')] #[Layout('components.layouts.admin')] class extends Component {
    use Toast, ManageProduct, WithFileUploads;

    public Product $product;
    public $availableFeatures;
    public $existingImagesToKeep = [];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->fill($this->product);
        $this->promotion = $product->promotion_price != null;

        $this->availableFeatures = Feature::all();
        $this->features = $product->features->pluck('pivot.value', 'id')->toArray();
        $this->existingImagesToKeep = $product->images->pluck('image')->toArray();
        $this->images = [];
    }

    public function removeImage(string $imageName): void
    {
        $key = array_search($imageName, $this->existingImagesToKeep);
        if ($key !== false) {
            unset($this->existingImagesToKeep[$key]);
            $this->existingImagesToKeep = array_values($this->existingImagesToKeep); // Réindexer le tableau
            $this->dispatch('image-removed'); // Événement pour forcer la mise à jour du frontend
        }
    }

    public function save(): void
    {
        $data = $this->validateProductData();

        if (!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        $this->product->update($data);

        $existingImages = $this->product->images->pluck('image')->toArray();
        $imagesToDelete = array_diff($existingImages, $this->existingImagesToKeep);
        if (!empty($imagesToDelete)) {
            $this->product->images()->whereIn('image', $imagesToDelete)->delete();
        }

        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                if ($image instanceof TemporaryUploadedFile) {
                    $path = $image->store('photos', 'public');
                    $this->product->images()->create([
                        'image' => basename($path),
                    ]);
                }
            }
        }

        $this->saveFeatures($this->product);

        $this->success(__('Product updated successfully.'), redirectTo: '/admin/products');
    }

    public function with(): array
    {
        return [
            'availableFeatures' => $this->availableFeatures,
            'existingImages' => $this->product->images->filter(fn($image) => in_array($image->image, $this->existingImagesToKeep)),
        ];
    }
};
?>

<div>
    <x-header title="{!! __('Catalogue') !!}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Edit a product') !!}">
        @include('livewire.admin.products.form')
    </x-card>
</div>
