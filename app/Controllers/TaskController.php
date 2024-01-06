<?php

namespace App\Controllers;
use App\Models\Tasks;

class TaskController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tasks',
        ];
        $tasksModel = new Tasks();
        $data['tasks'] = $tasksModel->getDataFromBoard('Default');
        echo view('pages/tasks', $data);
    }

}
