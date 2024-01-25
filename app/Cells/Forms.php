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
}
