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
        $data['personen'] = $personenModel->getDashboardData();
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
            $data['taskid'] = $taskModel->getInsertID();
            $data['spaletenid'] = $_POST['spaltenid'];
            $data['tableName'] = 'tasks';
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
        if ($TaskModel->delete($taskid)) {
            $data['taskid'] = $taskid;
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = ['deletion' => 'Task konnte nicht gelöscht werden'];
            $data['successfulValidation'] = false;
        }

        return json_encode($data);

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
            $data['taskid'] = $taskid;
            $data['spaletenid'] = $_POST['spaltenid'];
            // load data for task view_cell
//            $boardsModel = new BoardsModel();
//            $board['board'] = $boardsModel->getBoardName($_POST['boardid'])[0]['board'];
//            $spaletenModel = new SpaltenModel();
//            $spalte['spalte'] = $spaletenModel->getSpaltenName($_POST['spaltenid'])[0]['spalte'];
//            $taskartenModel = new TaskartenModel();
//            $taskart = $taskartenModel->getTaskart($_POST['taskartenid']);
//            $personenModel = new PersonenModel();
//            $person = $personenModel->getSecurePerson($_POST['personenid']);
//            $data['htmlElement'] = view_cell('Tasks::singleTask', array_merge($_POST, $board, $spalte, $taskart, $person));

            $data['tableName'] = 'tasks';
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
