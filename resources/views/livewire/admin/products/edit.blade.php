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

new
#[Title('Product edition')]
#[Layout('components.layouts.admin')]
class extends Component
{
    use Toast, ManageProduct, WithFileUploads;

    public Product $product;
    public $availableFeatures;
    public $images = []; // Propriété pour gérer un tableau d'images uploadées

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->fill($this->product); // Remplir les champs avec les données du produit
        $this->promotion = $product->promotion_price != null;

        // Initialiser les features disponibles
        $this->availableFeatures = Feature::all();

        // Charger les caractéristiques existantes du produit dans $features
        $this->features = $product->features->pluck('pivot.value', 'id')->toArray();

        // Charger les images existantes (optionnel, si vous voulez les afficher)
        $this->images = $product->images->pluck('image')->toArray();
    }

    public function save(): void
    {
        $data = $this->validateProductData();

        // Supprimer les données de promotion si elle n'est pas activée
        if (!$this->promotion) {
            $data['promotion_price'] = null;
            $data['promotion_start_date'] = null;
            $data['promotion_end_date'] = null;
        }

        // Mettre à jour le produit (on ne gère plus une seule image ici)
        $this->product->update($data);

        // Gestion des images multiples
        if (!empty($this->images)) {
            $existingImages = $this->product->images->pluck('image')->toArray();

            // Supprimer les anciennes images qui ne sont plus dans $this->images
            $this->product->images()->whereNotIn('image', array_filter($this->images, 'is_string'))->delete();

            // Ajouter les nouvelles images uploadées
            foreach ($this->images as $image) {
                if ($image instanceof TemporaryUploadedFile) {
                    $path = $image->store('photos', 'public');
                    $this->product->images()->create([
                        'image' => basename($path),
                    ]);
                } elseif (is_string($image) && !in_array($image, $existingImages)) {
                    // Si c'est une chaîne et qu'elle n'existait pas déjà, l'ajouter
                    $this->product->images()->create([
                        'image' => $image,
                    ]);
                }
            }
        }

        // Sauvegarder les caractéristiques
        $this->saveFeatures($this->product);

        $this->success(__('Product updated successfully.'), redirectTo: '/admin/products');
    }

    public function with(): array
    {
        return [
            'availableFeatures' => $this->availableFeatures,
            'existingImages' => $this->product->images, // Passer les images existantes à la vue
        ];
    }

    // Définir la relation dans le composant (bien que normalement dans le modèle Product)
    public function images(): HasMany
    {
        return $this->product->hasMany(\App\Models\ProductImages::class, 'product_unique_id', 'unique_id');
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
