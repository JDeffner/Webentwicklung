<?php

namespace App\Controllers;
use App\Models\PersonenModel;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        $personenModel = new PersonenModel();
        $data['personen'] = $personenModel->getSecureData();
        echo view('pages/admin/Dashboard', $data);
    }

}
