<?php

namespace App\Cells;

class Forms
{
    public function BoardForm()
    {
        return view('components/forms/BoardForm');
    }

    public function SpalteForm()
    {
        return view('components/forms/SpalteForm');
    }

    public function TaskForm()
    {
        return view('components/forms/TaskForm');
    }

    public function PersonForm()
    {
        return view('components/forms/PersonForm');
    }

    public function TaskartForm()
    {
        return view('components/forms/TaskartForm');
    }
}
