<?php

namespace Kovyakin\Test\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Kovyakin\Test\app\Http\Models\Table;


class TestComponent extends Component
{
    /**
     * Create a new component instance.
     */


    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $table = Table::all();
        return view('test::components.test-component')->with([
            'table'=>$table,
        ]);
    }
}
