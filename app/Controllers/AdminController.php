<?php

namespace App\Controllers;
use App\Models\PersonenModel;
use ReflectionException;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Personen',
        ];
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getDashboardData();
        echo view('pages/admin/Personen', $data);
    }

    public function getPersonenRawData()
    {
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getDashboardData();
        return json_encode($data);
    }

    public function postPersonInfo($personid)
    {
        $personenModel = new PersonenModel();
        $data['person'] = $personenModel->find($personid);
        return json_encode($data);
    }

    public function postPersonLoeschen($personid)
    {
        $personenModel = new PersonenModel();
        if($personenModel->delete($personid)) {
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = [ 'deletion' => 'Person konnte nicht gelöscht werden'];
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    /**
     * @throws ReflectionException
     */
    public function postPersonBearbeiten($personid)
    {
        $personenModel = new PersonenModel();
        if($personenModel->update($personid, $_POST)){
            $data['tableName'] = 'personen';
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $personenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }
}
