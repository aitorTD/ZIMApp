<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Admin extends Component
{
    /**
     * The page title.
     *
     * @var string
     */
    public $title;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @return void
     */
    public function __construct($title = null)
    {
        $this->title = $title ? "$title - " . config('app.name', 'Laravel') : config('app.name', 'Laravel') . ' - Admin';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(): View
    {
        return view('components.admin');
    }
}
