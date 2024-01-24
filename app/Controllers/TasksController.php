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
        if($this->validation->run($_POST, 'tasksErstellen')){
            $TaskModel = new TasksModel();
            $TaskModel->save($_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    public function postTaskLoeschen($boardid,$taskid)
    {
        $TaskModel = new TasksModel();
        $TaskModel->delete($taskid);
//        var_dump($id);

        return redirect()->to(base_url().'tasks/'.$boardid);

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


        if($this->validation->run($_POST, 'tasksBearbeiten')){
            $TaskModel = new TasksModel();
            $TaskModel->update($taskid, $_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);
    }


}
