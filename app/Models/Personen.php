<?php namespace App\Models;
use CodeIgniter\Model;
class Personen extends Model
{
    protected $table = 'personen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vorname', 'nachname', 'email', 'passwort'];
    public function getAllData(): array
    {
        $result = $this->db->query('SELECT * FROM personen');
        return $result->getResultArray();
    }
    public function getSecureData(): array
    {
        $result = $this->db->query('SELECT id, vorname, nachname, email FROM personen');
        return $result->getResultArray();
    }
}
