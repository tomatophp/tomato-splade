<?php

namespace ProtoneMedia\Splade\Components;

use Illuminate\View\Component;

class TableWrapper extends Component
{
    public function __construct(
        public bool $customBody = false,
    ) {
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('splade::table.wrapper');
    }
}
