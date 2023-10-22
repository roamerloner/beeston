<?php

namespace App\Http\Livewire\Variation;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Color;

class Addcolor extends Component
{
    public $color_code;
    public $color_name;


    public function insert_color()
    {
        Color::insert([
            'color_code' => $this->color_code,
            'color_name' => $this->color_name,
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()
        ]);
        $this->reset(['color_name', 'color_code']);
        session()->flash('success', 'Color successfully added.');
    }
    public function delete_color($id)
    {
        Color::find($id)->delete();
    }
    public function render()
    {
        $colors = Color::where('user_id', auth()->id())->latest()->get();
        return view('livewire.variation.addcolor', compact('colors'));
    }
}
