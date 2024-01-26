<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * @method insertID()
 */

class SpaltenModel extends Model
{
    protected $table = 'spalten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['boardsid', 'sortid', 'spalte', 'spaltenbeschreibung'];
    protected $cleanValidationRules = false;
    protected $validationRules = 'spalten';


    public function getSpaltenForBoard($boardID): array
    {
        return $this->db->table($this->table)
            ->where('boardsid', $boardID)
            ->get()->getResultArray();
    }

    public function getSpaltenWithBoardName(): array
    {
        return $this->db->table($this->table)
            ->select('spalten.id as id, spalten.boardsid, spalten.spalte as spalte, 
                spalten.spaltenbeschreibung as spaltenbeschreibung, boards.board as board, spalten.sortid as sortid')
            ->join('boards', 'boards.id = spalten.boardsid')
            ->get()->getResultArray();
    }

    public function getSpaltenName($spaltenID): array
    {
        return $this->db->table($this->table)
            ->select('spalte')
            ->where('id', $spaltenID)
            ->get()->getResultArray();
    }
}