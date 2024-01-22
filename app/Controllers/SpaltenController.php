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
            // update website base_url().'/spalten' without reloading it
            $data['successfulValidation'] = true;
            return json_encode($data);
        } else {
            $data['error'] = $this->validation->getErrors();
//            var_dump($data['error']);
            $data['successfulValidation'] = false;
            return json_encode($data);

        }
    }

    public function postSpalteBearbeiten($spaltenid)
    {
        if($this->validation->run($_POST, 'spaltenBearbeiten')){
            $SpaltenModel = new Spalten();
            $SpaltenModel->update($spaltenid, $_POST);
            return redirect()->to(base_url().'spalten');
        } else {
            $data['error'] = $this->validation->getErrors();
            return json_encode($data);
        }
    }

    public function postSpalteLoeschen($spaltenid)
    {
        $SpaltenModel = new Spalten();
        $SpaltenModel->delete($spaltenid);
        return redirect()->to(base_url().'spalten');
    }

}
