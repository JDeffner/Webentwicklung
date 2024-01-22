<?php

namespace App\Controllers;
use App\Models\Spalten;
use App\Models\Boards;

class SpaltenController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Spalten',
        ];
        $spaltenModel = new Spalten();
        $data['spalten'] = $spaltenModel->getSpaltenWithBoardName();
        $boardsModel = new Boards();
        $data['boards'] = $boardsModel->getAllData();
        echo view('pages/Spalten', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function postSpalteErstellen()
    {
        if($this->validation->run($_POST, 'spaltenErstellen')){
            $SpaltenModel = new Spalten();
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
            $SpaltenModel = new Spalten();
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
        $SpaltenModel = new Spalten();
        $SpaltenModel->delete($spaltenid);
        return redirect()->to(base_url().'spalten');
    }

}
