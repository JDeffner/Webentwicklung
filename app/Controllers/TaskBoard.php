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
//        var_dump($_POST);
//        if (!isset($_POST['erinnerung'])) {
//            // If 'erinnerung' is not set, set it to 0
//            $postData['erinnerung'] = 0;
//        } else if ($_POST['erinnerung'] == true) {
//            // If 'erinnerung' is set and is 'on', set it to 1
//            $postData['erinnerung'] = 1;
//        } else {
//            // If 'erinnerung' is set and is not 'on', set it to 0
//            $postData['erinnerung'] = 0;
//        }
        var_dump($_POST);
//        $TaskModel = new Tasks();
//        $TaskModel->save($_POST);
//        return redirect()->to(base_url().'/tasks');

    }

    public function postTaskLoeschen($taskid)
    {
        $TaskModel = new Tasks();
        $TaskModel->delete($taskid);
//        var_dump($id);

        return redirect()->to(base_url().'/tasks');

    }

    public function getTaskBearbeiten($taskid)
    {
//        $TaskModel = new Tasks();
//        $data = $TaskModel->find($taskid);
//        echo json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postTaskBearbeiten($taskid)
    {
        if (!isset($_POST['erinnerung'])) {
            // If 'erinnerung' is not set, set it to 0
            $_POST['erinnerung'] = '0';
        }
        $TaskModel = new Tasks();
        $TaskModel->update($taskid, $_POST);
        return redirect()->to(base_url().'/tasks');
    }


}
