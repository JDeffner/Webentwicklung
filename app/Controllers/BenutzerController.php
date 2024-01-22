<?php

namespace App\Controllers;
use App\Models\Personen;

class BenutzerController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        echo view('pages/BenutzerAnmelden', $data);
    }



    public function getBenutzerErstellen(){
        $data = [
            'title' => 'Neuer Benutzer',

        ];
//        if($this->request->getMethod() == 'post')
        echo view('pages/BenutzerErstellen', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function postBenutzerErstellen(){
        $personenModel = new Personen();
        $personenModel->save($_POST);
        $userid = $personenModel->insertID();
        return redirect()->to(base_url().'benutzer/'.$userid);
    }

    public function getBenutzer($userid){
        $personenModel = new Personen();
        $data = [
            'title' => 'Profil',
        ];
        $data['person'] = $personenModel->select('id, vorname, nachname, email')->where('id', $userid)->first();
        echo view('pages/Benutzer', $data);
    }

}
