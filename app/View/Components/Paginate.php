<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Paginate extends Component
{
    public $inPage;
    public $totalPage;
    public $prePage;
    public $nextPage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($inPage, $totalPage, $prePage, $nextPage)
    {
        $this->inPage = $inPage;
        $this->totalPage = $totalPage;
        $this->prePage = $prePage;
        $this->nextPage = $nextPage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.paginate');
    }
}
