<?php

namespace App\Controllers;
use App\Models\Tasks;
use App\Models\Personen;
use App\Models\Spalten;
use App\Models\Boards;
use App\Models\Taskarten;
use ReflectionException;

class TaskBoard extends BaseController
{

    public function index($boardID)
    {
        $data = [
            'title' => 'Tasks',
            'boardID' => $boardID,
        ];
        $tasksModel = new Tasks();
        $data['tasks'] = $tasksModel->getTasksFromBoard($boardID);
        $personenModel = new Personen();
        $data['personen'] = $personenModel->getSecureData();
        $spaltenModel = new Spalten();
        $data['spalten'] = $spaltenModel->getAllData();
        $data['spaltenForBoard'] = $spaltenModel->getSpaltenForBoard($boardID);
        $boardsModel = new Boards();
        $data['boards'] = $boardsModel->getAllData();
        $taskartenModel = new Taskarten();
        $data['taskarten'] = $taskartenModel->getAllData();

        echo view('pages/Tasks', $data);
    }

    public function getTaskErstellen()
    {
        $data = [
            'title' => 'Task Erstellen',
        ];

        $personenModel = new Personen();
        $data['personen'] = $personenModel->getSecureData();
        $spaltenModel = new Spalten();
        $data['spalten'] = $spaltenModel->getAllData();
        $boardsModel = new Boards();
        $data['boards'] = $boardsModel->getAllData();
        $taskartenModel = new Taskarten();
        $data['taskarten'] = $taskartenModel->getAllData();

        echo view('pages/TaskErstellen', $data);

    }


    /**
     * @throws ReflectionException
     */
    public function postTaskErstellen()
    {
        if (!isset($postData['erinnerung'])) {
            // If 'erinnerung' is not set, set it to 0
            $postData['erinnerung'] = 0;
        }
//        var_dump($_POST);
        $TaskModel = new Tasks();
        $TaskModel->save($_POST);
        return redirect()->to(base_url().'/tasks');

    }

    public function postTaskLoeschen($taskid)
    {
        $TaskModel = new Tasks();
        $TaskModel->delete($taskid);
//        var_dump($id);

        return redirect()->to(base_url().'/tasks');

    }
//
//    public function getTaskBearbeiten($id)
//    {
//        $data = [
//            'title' => 'Task Erstellen',
//            'id' => $id,
//        ];
//        echo view('pages/TaskErstellen', $data);
//
//    }

    /**
     * @throws ReflectionException
     */
    public function postTaskBearbeiten($taskid)
    {
        $data = [
            'title' => 'Task Erstellen',
        ];
//        var_dump($_POST);
        $TaskModel = new Tasks();
        $TaskModel->update($taskid, $_POST);
        return redirect()->to(base_url().'/tasks');

    }

}
