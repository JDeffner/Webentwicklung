<?php

namespace App\Models;

use CodeIgniter\Model;

class Spalten extends Model
{
    protected $table = 'spalten';
    protected $primaryKey = 'id';
    protected $allowedFields = ['boardsid', 'sortid', 'spalte', 'spaltenbeschreibung'];

    public function getAllData()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function getSpaltenForBoard($boardID)
    {
        return $this->db->table($this->table)->where('boardsid', $boardID)->get()->getResultArray();
    }

    public function getSpaltenWithBoardName()
    {
        return $this->db->table($this->table)
            ->select('spalten.id as id, boards.id as boardid, spalten.spalte as spalte, spalten.spaltenbeschreibung as spaltenbeschreibung, boards.board as board, spalten.sortid as sortid')
            ->join('boards', 'boards.id = spalten.boardsid')
            ->get()->getResultArray();
    }
}