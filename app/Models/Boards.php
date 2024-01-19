<?php

namespace App\Models;

use CodeIgniter\Model;

class Boards extends Model
{
    protected $table = 'boards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['board'];

    public function getAllData()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }
}