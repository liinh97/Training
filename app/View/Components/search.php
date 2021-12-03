<?php

namespace App\View\Components;

use Illuminate\View\Component;

class search extends Component
{
    public $className;
    public $url;
    public $oldValue;
    public $value;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($className, $url, $oldValue, $value)
    {
        $this->className = $className;
        $this->url = $url;
        $this->oldValue = $oldValue;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search');
    }
}
