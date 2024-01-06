<?php namespace App\Models;
use CodeIgniter\Model;
class Test extends Model
{
    protected $table = 'personen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['vorname', 'nachname', 'email', 'passwort'];
    public function getData()
    {
        $result = $this->db->query('SELECT * FROM personen');
        return $result->getResultArray();
    }
}
