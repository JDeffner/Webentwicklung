<?php

namespace App\Controllers;
use App\Models\SpaltenModel;
use App\Models\BoardsModel;

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
     * @throws \ReflectionException
     */
    public function postSpalteErstellen()
    {
        if($this->validation->run($_POST, 'spaltenErstellen')){
            $SpaltenModel = new SpaltenModel();
            $SpaltenModel->save($_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);
    }

    /**
     * @throws \ReflectionException
     */
    public function postSpalteBearbeiten($spaltenid)
    {
        if($this->validation->run($_POST, 'spaltenBearbeiten')){
            $SpaltenModel = new SpaltenModel();
            $SpaltenModel->update($spaltenid, $_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function postSpalteLoeschen($spaltenid)
    {
        $SpaltenModel = new SpaltenModel();
        $SpaltenModel->delete($spaltenid);
        return redirect()->to(base_url().'spalten');
    }

}
