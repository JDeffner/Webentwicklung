<?php

namespace App\Controllers;
use App\Models\Personen;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        $personenModel = new Personen();
        $data['personen'] = $personenModel->getSecureData();
        echo view('pages/AdminDashboard', $data);
    }

}
