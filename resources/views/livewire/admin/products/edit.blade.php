<?php

use Mary\Traits\Toast;
use App\Models\Product;
use Livewire\Volt\Component;
use App\Traits\ManageProduct;
use Livewire\WithFileUploads;
use Livewire\Attributes\{Layout, Title};
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

new
#[Title('Product edition')]
#[Layout('components.layouts.admin')]
class extends Component
{
    use Toast, ManageProduct, WithFileUploads;

    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->fill($this->product);
        $this->promotion = $product->promotion_price != null;
    }

    public function save(): void
    {
        $data = $this->validateProductData();
// Gestion de l'image
if ($this->image instanceof TemporaryUploadedFile) {
    $path = $this->image->store('photos', 'public'); // Stocker le fichier
    $data['image'] = basename($path); // Extraire uniquement le nom du fichier
    //dd($this->image, $path, $data['image']); // Vérifiez les valeurs
} elseif (is_string($this->image) && !str_contains($this->image, '/tmp/')) {
    $data['image'] = $this->image; // Conserver une image existante valide
} elseif (!$this->image && $this->product->image) {
    $data['image'] = $this->product->image; // Conserver l'image actuelle si aucune nouvelle
}

        // if ($this->image instanceof TemporaryUploadedFile) {
        //     $path = basename($this->image->store('photos', 'public'));
        //     $data['image'] = $path;
        // }
        if(!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        $this->product->update($data);

        $this->success(__('Product updated successfully.'), redirectTo: '/admin/products');
    }

}; ?>

<div>
    <x-header title="{!! __('Catalogue') !!}" separator progress-indicator>
        <x-slot:actions>
            <x-button
                icon="s-building-office-2"
                label="{{ __('Dashboard') }}"
                class="btn-outline lg:hidden"
                link="{{ route('admin') }}"
            />
        </x-slot:actions>
    </x-header>
    <x-card title="{!! __('Edit a product') !!}">
        @include('livewire.admin.products.form')
    </x-card>
</div>
