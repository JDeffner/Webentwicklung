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
//        var_dump($_POST);
        $TaskModel = new Tasks();
        $TaskModel->save($_POST);
        return redirect()->to(base_url().'/tasks');

    }

    public function postTaskLoeschen($id)
    {
        $TaskModel = new Tasks();
        $TaskModel->delete($id);
//        var_dump($id);

        return redirect()->to(base_url().'/tasks');

    }

    public function getTaskBearbeiten($id)
    {
        $data = [
            'title' => 'Task Erstellen',
            'id' => $id,
        ];
        echo view('pages/TaskErstellen', $data);

    }

    public function postTaskBearbeiten($id)
    {
        $data = [
            'title' => 'Task Erstellen',
        ];
//        var_dump($_POST);
        $TaskModel = new Tasks();
        $TaskModel->update($id, $_POST);
        return redirect()->to(base_url().'/tasks');

    }

}
