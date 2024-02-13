<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;
use Livewire\Attributes\On;

class Polls extends Component
{

    #[On('pollCreated')]
    public function render()
    {
        $polls = \App\Models\Poll::with('options.votes')->latest()->get();

        return view('livewire.polls', ['polls' => $polls]);
    }


    // Method 1
    // public function vote($optionId)
    // {
    //     $option = \App\Models\Option::findOrFail($optionId);
    //     $option->votes()->create();
    // }

    // Method 2 Using Data Model Binding
    function vote(Option $option)
    {
        $option->votes()->create();
    }
}