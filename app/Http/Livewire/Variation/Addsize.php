<?php

namespace App\Http\Livewire\Variation;
use App\Models\Size;
use Livewire\Component;
use Carbon\Carbon;

class Addsize extends Component
{
    public $size;

    public function insert_size()
    {
        Size::insert([
            'size' => $this->size,
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()
        ]);
        $this->reset('size');
        session()->flash('success', 'Size successfully added.');
    }

    public function delete_size($id)
    {
        Size::find($id)->delete();
    }
    public function render()
    {
        $sizes = Size::where('user_id', auth()->id())->latest()->get();
        return view('livewire.variation.addsize', compact('sizes'));
    }
}
