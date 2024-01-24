<?php

namespace App\Models;

use CodeIgniter\Model;

class Taskarten extends Model
{
    protected $table = 'taskarten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['taskart', 'taskartenicon'];

    public function getAllData(): array
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }
}