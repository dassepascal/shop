<?php

use App\Models\{Address, Country};
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Mary\Traits\Toast;
use Illuminate\Support\Collection;
use App\Traits\ManageAddress;

new #[Title('Update address')] 
class extends Component {
    use Toast, ManageAddress;

    public Address $myAddress;

    public function mount(Address $address): void
    {
        $this->myAddress = $address;
        $this->fill($this->myAddress);
        $this->countries = Country::all();
    }

    public function save(): void
    {
        $data = $this->validate($this->rules());
         // Assurez-vous que la civilité est correctement formatée
         if ($data['civility'] === 'M') {
            $data['civility'] = 'M.';
        } elseif ($data['civility'] === 'Mme') {
            $data['civility'] = 'Mme';
        } else {
            // Gérer l'erreur ou définir une valeur par défaut
            $data['civility'] = 'M.'; // ou 'Mme' selon votre logique
        }

        $this->myAddress->update($data);

        $this->success(__('Address updated with success.'), redirectTo: '/account/addresses');
    }
};

?>

@include('livewire.account.addresses.components.form', ['title' => __('Update an address')])