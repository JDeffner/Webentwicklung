<?php

namespace App\Controllers;
use App\Models\Tasks;
use ReflectionException;

class TaskController extends BaseController
{

    public function index()
    {
        $data = [
            'title' => 'Tasks',
        ];
        $tasksModel = new Tasks();
        $data['tasks'] = $tasksModel->getDataFromBoard('Default');
        $data['spalten'] = $tasksModel->getAllSpalten();
        echo view('pages/Tasks', $data);
    }

    public function getTaskErstellen()
    {
        $data = [
            'title' => 'Task Erstellen',
        ];
        echo view('pages/TaskErstellen', $data);

    }

    /**
     * @throws ReflectionException
     */
    public function postTaskErstellen()
    {
        $data = [
            'title' => 'Task Erstellen',
        ];
        var_dump($_POST);
//        $TaskModel = new Tasks();
//        $TaskModel->save($_POST);
//        echo view('pages/TaskErstellen', $data);

    }

}
