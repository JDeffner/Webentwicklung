<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class BoardsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Boards',
        ];
        echo view('pages/Boards', $data);
    }

    public function getRawData()
    {
        $BoardsModel = new BoardsModel();
        $data['boards'] = $BoardsModel->getAllData();
        return json_encode($data);
    }

    public function postBoardErstellen()
    {
        if($this->validation->run($_POST, 'boardsErstellen')){
            $BoardsModel = new BoardsModel();
            $BoardsModel->save($_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    public function postBoardBearbeiten($boardid)
    {
        if($this->validation->run($_POST, 'boardsBearbeiten')){
            $BoardsModel = new BoardsModel();
            $BoardsModel->update($boardid, $_POST);
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $this->validation->getErrors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    public function postBoardLoeschen($boardid)
    {
        $BoardsModel = new BoardsModel();
        $BoardsModel->delete($boardid);
        return redirect()->to(base_url().'boards');
    }

}
