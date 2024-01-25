<?php namespace App\Models;
use CodeIgniter\Model;

/**
 * @method insertID()
 */
class PersonenModel extends Model
{
    protected $table = 'personen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vorname', 'nachname', 'email', 'passwort'];

    protected $cleanValidationRules = false;
    protected $validationRules = 'benutzerErstellen';

    public function getSecureData(): array
    {

        return $this->db->table($this->table)
            ->select('id, vorname, nachname, email, permission')
            ->get()->getResultArray();
    }

    public function getPersonenRowByEmail($email): array
    {
        // $person = $personenModel->where('email', $_POST['email'])->first();
        return $this->db->table($this->table)
            ->where('email', $email)
            ->get()->getRowArray();
    }

}
