<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * @method insertID()
 */

class TaskartenModel extends Model
{
    protected $table = 'taskarten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['taskart', 'taskartenicon'];

    public function getTaskart($taskartenid): array
    {
        return $this->db->table($this->table)
            ->select('taskart, taskartenicon')
            ->where('id', $taskartenid)
            ->get()->getResultArray();
    }

}