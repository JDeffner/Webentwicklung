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
        $SpaltenModel = new Spalten();
        $SpaltenModel->save($_POST);
        return redirect()->to(base_url().'/spalten');
    }

    public function postSpalteBearbeiten($spaltenid)
    {

        $SpaltenModel = new Spalten();
        $SpaltenModel->update($spaltenid, $_POST);
        return redirect()->to(base_url().'/spalten');
    }

    public function postSpalteLoeschen($spaltenid)
    {
        $SpaltenModel = new Spalten();
        $SpaltenModel->delete($spaltenid);
        return redirect()->to(base_url().'/spalten');
    }

}
