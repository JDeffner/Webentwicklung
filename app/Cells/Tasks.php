<?php

namespace App\Cells;


class Tasks
{
    public function singleTask(array $params) {
        return view('components/Task', $params);
    }

}
