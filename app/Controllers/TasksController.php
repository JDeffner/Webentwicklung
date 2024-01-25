<?php

namespace App\Controllers;
use App\Models\TasksModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\BoardsModel;
use App\Models\TaskartenModel;
use ReflectionException;

class TasksController extends BaseController
{


    public function index($boardID)
    {
        $data = [
            'title' => 'Tasks',
            'boardID' => $boardID,
        ];
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getTasksFromBoard($boardID);
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getSecureData();
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->findAll();
        $data['spaltenForBoard'] = $spaltenModel->getSpaltenForBoard($boardID);
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->findAll();
        $data['boardName'] = $boardsModel->getBoardName($boardID)[0]['board'];
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->findAll();

        echo view('pages/Tasks', $data);
    }



    /**
     * @throws ReflectionException
     */
    public function postTaskErstellen()
    {
        $taskModel = new TasksModel();
        if($taskModel->save($_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $taskModel->errors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    public function postTaskLoeschen($taskid)
    {
        $TaskModel = new TasksModel();
        $TaskModel->delete($taskid);
//        var_dump($id);

        return redirect()->to(base_url().'tasks');

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

        $taskModel = new TasksModel();
        if($taskModel->update($taskid, $_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $taskModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function postTaskInfo($taskid)
    {
        $taskModel = new TasksModel();
        $data['task'] = $taskModel->find($taskid);
        $taskartenModel = new TaskartenModel();
        $data['taskarten'] = $taskartenModel->find($data['task']['taskartenid']);
        return json_encode($data);
    }


}
