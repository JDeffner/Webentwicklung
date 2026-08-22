<?php

namespace App\Controllers;
use App\Models\PersonenModel;
use ReflectionException;

class BenutzerController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        session()->destroy();
        echo view('pages/user/BenutzerAnmelden', $data);
    }

    public function postBenutzerAnmelden()
    {

            $personenModel = new PersonenModel();
            $person = $personenModel->getPersonenRowByEmail($this->request->getPost('email'));
            if ($person != null) {
                if (password_verify($this->request->getPost('passwort'), $person['passwort'])) {
                    session()->set([
                        'userid'          => $person['id'],
                        'username'        => $person['vorname'],
                        'userlastname'    => $person['nachname'],
                        'useremail'       => $person['email'],
                        'permissionLevel' => (string) $person['permission'],
                    ]);
                    $data['redirect'] = base_url('profil');
                    $data['tableName'] = 'loginPersonen';
                    $data['successfulValidation'] = true;
                    return json_encode($data);
                } else {
                    $data['error'] = [ 'passwort' => 'Das Passwort ist falsch'];
                    $data['successfulValidation'] = false;
                    return json_encode($data);
                }
            } else {
                $data['error'] = [ 'email' => 'Benutzer nicht gefunden'];
                $data['successfulValidation'] = false;
                return json_encode($data);
            }

    }



    public function getBenutzerErstellen(){
        $data = [
            'title' => 'Neuer Benutzer',
        ];
        echo view('pages/user/BenutzerErstellen', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function postBenutzerErstellen(){

        $personenModel = new PersonenModel();
        // Only these four fields may come from the request. permission is set by
        // the server so that nobody can register themselves as an administrator.
        $person = [
            'vorname'  => $this->request->getPost('vorname'),
            'nachname' => $this->request->getPost('nachname'),
            'email'    => $this->request->getPost('email'),
            'passwort' => $this->request->getPost('passwort'),
        ];
        if($personenModel->validate($person)){
            $person['passwort'] = password_hash($person['passwort'], PASSWORD_DEFAULT);
            $person['permission'] = 1;
            $personenModel->save($person);
            $userid = $personenModel->insertID();
            session()->set([
                'userid'          => $userid,
                'username'        => $person['vorname'],
                'userlastname'    => $person['nachname'],
                'useremail'       => $person['email'],
                'permissionLevel' => '1',
            ]);
            $data['redirect'] = base_url('willkommen');
            $data['tableName'] = 'loginPersonen';
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $personenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function getBenutzerWillkommen(){
        $data = [
            'title' => 'Willkommen',
        ];
        echo view('pages/user/BenutzerWillkommen', $data);
    }

    public function getGastAnmelden(){
        session()->destroy();
        session()->set('permissionLevel', '0');
        return redirect()->to(base_url('tasks'));
    }

    public function getBenutzerProfil(){
        $data = [
            'title' => 'Profil',
        ];
        echo view('pages/user/BenutzerProfil', $data);
    }

}
