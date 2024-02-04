<?php

namespace App\Controllers;

class InfoController extends BaseController
{
    public function getImpressum()
    {
        $data = [
            'title' => 'Impressum',
        ];
        echo view('pages/info/Impressum', $data);
    }

    public function getDatenschutz()
    {
        $data = [
            'title' => 'Datenschutz',
        ];
        echo view('pages/info/Datenschutz', $data);
    }
}