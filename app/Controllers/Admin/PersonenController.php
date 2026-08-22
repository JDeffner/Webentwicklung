<?php

namespace App\Controllers\Admin;
use App\Models\PersonenModel;
use ReflectionException;
use App\Controllers\BaseController;

class PersonenController extends BaseController
{
    public function getPersonen()
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
        // Never ship the password hash to the client.
        $data['person'] = $personenModel->getSecurePersonForEdit($personid);
        return json_encode($data);
    }

    public function postPersonLoeschen($personid)
    {
        $personenModel = new PersonenModel();
        if($personenModel->delete($personid)) {
            $data['tableName'] = 'personen';
            $data['action'] = 'gelöscht';
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
        $person = [
            'vorname'    => $this->request->getPost('vorname'),
            'nachname'   => $this->request->getPost('nachname'),
            'permission' => $this->request->getPost('permission'),
        ];
        if($personenModel->update($personid, $person)){
            $data['tableName'] = 'personen';
            $data['action'] = 'bearbeitet';
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $personenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }
}
