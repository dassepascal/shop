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

    // Déclarer la propriété publique ici
    public $availableFeatures;

    public function mount(): void
    {
        $this->availableFeatures = Feature::all(); // Charger les features disponibles
    }

    public function save(): void
    {
        $data = $this->validateProductData();

        // Gestion de l'image
        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $path = basename($this->image->store('photos', 'public'));
            $data['image'] = $path;
        }

        // Supprimer les données de promotion si elle n'est pas activée
        if (!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        // Créer le produit et stocker l'instance
        $product = Product::create($data);
        $this->saveFeatures($product); // Sauvegarder les caractéristiques

        $this->success(__('Product created successfully.'), redirectTo: '/admin/products');
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
    <x-card title="{!! __('Create a new product') !!}">
        @include('livewire.admin.products.form')
    </x-card>
</div>
