<?php namespace App\Models;
use CodeIgniter\Model;
class Personen extends Model
{
    protected $table = 'personen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vorname', 'nachname', 'email', 'passwort'];
    public function getAllData()
    {
        $result = $this->db->query('SELECT * FROM personen');
        return $result->getResultArray();
    }
}
