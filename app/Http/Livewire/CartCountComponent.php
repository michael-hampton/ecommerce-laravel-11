<?php



namespace App\Http\Livewire;

use Livewire\Component;

class CartCountComponent extends Component
{
    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.cart-count-component');
    }
}
