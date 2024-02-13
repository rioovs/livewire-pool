<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;
use Livewire\Attributes\Validate;

class CreatePoll extends Component
{
    // #[Validate]
    public $title;
    public $options = ['First'];
    protected $rules = [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:1|max:10', // this for property array
        'options.*' => 'required|min:1|max:255' // and this for array
    ];

    protected $messages = [
        'options.*' => "This Field can'n be empty."
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function createPoll()
    {
        $this->validate();
        // Method 2 with laravel collection
        Poll::create([
            'title' => $this->title,
        ])->options()->createMany(
                collect($this->options)
                    ->map(fn($option) => ['name' => $option])
                    ->all()
            );

        // Method 1
        // $poll = Poll::create([
        //     'title' => $this->title,
        // ]);
        // foreach ($this->options as $optionName) {
        //     $poll->options()->create([
        //         'name' => $optionName,
        //     ]);
        // }

        $this->reset('title', 'options');
        $this->dispatch('pollCreated');
    }
}