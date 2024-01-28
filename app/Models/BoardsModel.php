<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * @method insertID()
 */

class BoardsModel extends Model
{
    protected $table = 'boards';
    protected $primaryKey = 'id';
    protected $allowedFields = ['board'];
    protected $validationRules = 'boards';


    public function getBoardName($boardID): array
    {
        return $this->db->table($this->table)
            ->select('board')
            ->where('id', $boardID)
            ->get()->getResultArray();
    }
}