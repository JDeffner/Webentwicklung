<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
    protected $table = 'boards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['board'];


    public function getBoardName($boardID): array
    {
        return $this->db->table($this->table)
            ->select('board')
            ->where('id', $boardID)
            ->get()->getResultArray();
    }
}