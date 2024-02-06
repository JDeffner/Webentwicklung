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


    public function index()
    {
        $defaultBoardID = '1';
        $data = [
            'title' => 'Tasks',
            'boardID' => $defaultBoardID,
        ];
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getTasksFromBoard($defaultBoardID);
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getDashboardData();
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->findAll();
        $data['spaltenForBoard'] = $spaltenModel->getSpaltenForBoard($defaultBoardID);
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->findAll();
        $data['boardName'] = $boardsModel->getBoardName($defaultBoardID)[0]['board'];
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
            $data['action'] = 'erstellt';
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
            $data['tableName'] = 'tasks';
            $data['taskid'] = $taskid;
            $data['action'] = 'gelöscht';
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
            $data['tableName'] = 'tasks';
            $data['action'] = 'bearbeitet';
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

    public function getRawDataBoard($boardID)
    {
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getTasksFromBoard($boardID);
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getSpaltenForBoard($boardID);
        return json_encode($data);
    }

    public function getRawData()
    {
        $tasksModel = new TasksModel();
        $data['tasks'] = $tasksModel->getTasksWithAllNames();
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postTaskSpalteBearbeiten($taskid, $spaltenid)
    {
        $taskModel = new TasksModel();
        $data['taskid'] = $taskid;
        $data['spaltenid'] = $spaltenid;
        if ($taskModel->update($taskid, ['spaltenid' => $spaltenid])) {
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $taskModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postTaskSortIDBearbeiten($taskid, $sortid)
    {
        $taskModel = new TasksModel();
        $data['taskid'] = $taskid;
        $data['sortid'] = $sortid;
        if ($taskModel->update($taskid, ['sortid' => $sortid])) {
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $taskModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }


}
