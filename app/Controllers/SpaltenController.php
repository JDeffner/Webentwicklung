<?php

namespace App\Controllers;
use App\Models\SpaltenModel;
use App\Models\BoardsModel;
use ReflectionException;

class SpaltenController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Spalten',
        ];
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getSpaltenWithBoardName();
        $boardsModel = new BoardsModel();
        $data['boards'] = $boardsModel->findAll();
        echo view('pages/Spalten', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function postSpalteErstellen()
    {
        $spaltenModel = new SpaltenModel();
        if($spaltenModel->save($_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $spaltenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postSpalteBearbeiten($spaltenid)
    {
        $spaltenModel = new SpaltenModel();
        if($spaltenModel->update($spaltenid, $_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $spaltenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function postSpalteLoeschen($spaltenid)
    {
        $spaltenModel = new SpaltenModel();
        if($spaltenModel->delete($spaltenid)) {
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = [ 'deletion' => 'Spalte konnte nicht gelöscht werden, da sie noch Tasks enthält'];
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function getRawData()
    {
        $spaltenModel = new SpaltenModel();
        $data['spalten'] = $spaltenModel->getSpaltenWithBoardName();
        return json_encode($data);
    }

}
