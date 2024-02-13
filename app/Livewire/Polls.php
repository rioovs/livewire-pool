<?php

namespace App\Livewire;

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
}