<?php namespace App\Models;
use CodeIgniter\Model;

/**
 * @method insertID()
 */
class PersonenModel extends Model
{
    protected $table = 'personen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vorname', 'nachname', 'email', 'passwort', 'permission'];

    protected $validationRules = 'personen';

    public function getDashboardData(): array
    {

        return $this->db->table($this->table)
            ->select('id, vorname, nachname, email, permission')
            ->get()->getResultArray();
    }

    public function getPersonenRowByEmail($email): array | null
    {
        return $this->db->table($this->table)
            ->where('email', $email)
            ->get()->getRowArray();
    }

    public function getSecurePerson($id): array
    {
        return $this->db->table($this->table)
            ->select('vorname, nachname')
            ->where('id', $id)
            ->get()->getResultArray();
    }

}
