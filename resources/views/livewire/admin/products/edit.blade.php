<?php

use Mary\Traits\Toast;
use App\Models\Feature; // Ajout de l'import pour Feature
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
    public $availableFeatures; // Déclarer la propriété publique

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->fill($this->product); // Remplir les champs avec les données du produit
        $this->promotion = $product->promotion_price != null;

        // Initialiser les features disponibles
        $this->availableFeatures = Feature::all();

        // Charger les caractéristiques existantes du produit dans $features
        $this->features = $product->features->pluck('pivot.value', 'id')->toArray();
    }

    public function save(): void
    {
        $data = $this->validateProductData();

        // Gestion de l'image
        if ($this->image instanceof TemporaryUploadedFile) {
            $path = $this->image->store('photos', 'public');
            $data['image'] = basename($path);
        } elseif (is_string($this->image) && !str_contains($this->image, '/tmp/')) {
            $data['image'] = $this->image;
        } elseif (!$this->image && $this->product->image) {
            $data['image'] = $this->product->image;
        }

        // Supprimer les données de promotion si elle n'est pas activée
        if (!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        // Mettre à jour le produit
        $this->product->update($data);

        // Sauvegarder les caractéristiques
        $this->saveFeatures($this->product);

        $this->success(__('Product updated successfully.'), redirectTo: '/admin/products');
    }

    public function with(): array
    {
        return [
            'availableFeatures' => $this->availableFeatures, // Passer à la vue
        ];
    }
};
?>

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
