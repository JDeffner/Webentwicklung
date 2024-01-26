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
        setcookie('userid', "", time() - 3600, "/");
        setcookie('username', "", time() - 3600, "/");
        setcookie('userlastname', "", time() - 3600, "/");
        setcookie('useremail', "", time() - 3600, "/");
        setcookie('permissionLevel', "", time() - 3600, "/");
        echo view('pages/BenutzerAnmelden', $data);
    }

    public function postBenutzerAnmelden()
    {

            $personenModel = new PersonenModel();
            $person = $personenModel->getPersonenRowByEmail($_POST['email']);
            if ($person != null) {
                if (password_verify($_POST['passwort'], $person['passwort'])) {
                    setcookie('userid', $person['id'], "0", "/");
                    setcookie('username', $person['vorname'], "0", "/");
                    setcookie('userlastname', $person['nachname'], "0", "/");
                    setcookie('useremail', $person['email'], "0", "/");
                    setcookie('permissionLevel', $person['permission'], "0", "/");
                    $data['redirect'] = base_url('benutzer/'.$person['id']);
                    $data['tableName'] = 'personen';
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
        echo view('pages/BenutzerErstellen', $data);
    }

    /**
     * @throws ReflectionException
     */
    public function postBenutzerErstellen(){
        $personenModel = new PersonenModel();
        if($personenModel->validate($_POST)){
            $_POST['passwort'] = password_hash($_POST['passwort'], PASSWORD_DEFAULT);
            $personenModel->save($_POST);
            setcookie('username', $_POST['vorname'], "0", "/");
            setcookie('userlastname', $_POST['nachname'], "0", "/");
            setcookie('useremail', $_POST['email'], "0", "/");
            setcookie('permissionLevel', "1", "0", "/");
            $userid = $personenModel->insertID();
            setcookie('userid', $userid, "0", "/");
            $data['redirect'] = base_url('benutzer/'.$userid);
            $data['tableName'] = 'personen';
            $data['successfulValidation'] = true;
        } else {
            $data['error'] = $personenModel->errors();
            $data['successfulValidation'] = false;
        }
        return json_encode($data);
    }

    public function getBenutzer($userid){
        if ($userid != $_COOKIE['userid']) {
            return redirect()->to(base_url('denied'));
        }
        $personenModel = new PersonenModel();
        $data = [
            'title' => 'Profil',
        ];
        echo view('pages/Benutzer', $data);
    }

    public function getGastAnmelden(){
        setcookie('userid', "", "0", "/");
        setcookie('username', "", "0", "/");
        setcookie('userlastname', "", "0", "/");
        setcookie('useremail', "", "0", "/");
        setcookie('permissionLevel', "0", "0", "/");
        return redirect()->to(base_url('tasks'));
    }

}
