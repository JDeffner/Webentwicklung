<?php

namespace App\Controllers\Admin;

use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class TasksController extends \App\Controllers\TasksController
{
    public function getTasks()
    {
        $defaultBoardID = '1';
        $data = [
            'title' => 'Tasks-Admin',
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
        echo view('pages/admin/Tasks', $data);
    }
}
