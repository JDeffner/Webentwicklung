<?php

namespace App\Cells;


use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Tasks
{
    public function singleTask(array $params) {
        return view('components/Task', $params);
    }

}
