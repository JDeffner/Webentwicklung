<?php

namespace App\Cells;


use App\Models\BoardsModel;
use App\Models\PersonenModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\TasksModel;

class Tasks
{
    public function taskBoard($boardID) {
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

        return view('components/TaskBoard', $data);
    }
    public function singleTask(array $params) {
        return view('components/Task', $params);
    }

}
