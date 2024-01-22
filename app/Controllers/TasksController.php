<?php

namespace App\Controllers;
use App\Models\Tasks;
use App\Models\Personen;
use App\Models\Spalten;
use App\Models\Boards;
use App\Models\Taskarten;
use ReflectionException;

class TasksController extends BaseController
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
        $data['boardName'] = $boardsModel->getBoardName($boardID)[0]['board'];
//        var_dump($data['boardName']);
        $taskartenModel = new Taskarten();
        $data['taskarten'] = $taskartenModel->getAllData();

        echo view('pages/Tasks', $data);
    }



    /**
     * @throws ReflectionException
     */
    public function postTaskErstellen()
    {
        if($this->validation->run($_POST, 'tasksErstellen')){
            $TaskModel = new Tasks();
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
        $TaskModel = new Tasks();
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
            $TaskModel = new Tasks();
            $TaskModel->update($taskid, $_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);
    }


}
