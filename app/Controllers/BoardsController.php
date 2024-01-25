<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use ReflectionException;

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
        $data['boards'] = $BoardsModel->findAll();
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postBoardErstellen()
    {
        $boardsModel = new BoardsModel();
        if($boardsModel->save($_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $boardsModel->errors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    /**
     * @throws ReflectionException
     */
    public function postBoardBearbeiten($boardid)
    {
        $boardsModel = new BoardsModel();
        if($boardsModel->update($boardid, $_POST)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $boardsModel->errors();
            $data['successfulValidation'] = false;

        }
        return json_encode($data);

    }

    public function postBoardLoeschen($boardid)
    {
        $boardsModel = new BoardsModel();
        if($boardsModel->delete($boardid)){
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = [ 'deletion' => 'Sie können dieses Board nicht löschen, da es noch Spalten enthält'];
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
//        return redirect()->to(base_url().'boards');
    }

}
