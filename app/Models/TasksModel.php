<?php namespace App\Models;
use CodeIgniter\Model;
class TasksModel extends Model

    /**
     * @method insertID()
     */
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $allowedFields = ['sortid', 'task', 'erinnerungsdatum', 'erinnerung', 'notizen',
        'erledigt', 'geloescht', 'personenid', 'taskartenid', 'spaltenid'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'erstelldatum';
    protected $updatedField = '';

    protected $validationRules = 'tasks';

    public function getTasksFromBoard($BoardID): array
    {
        return $this->db->table($this->table)
            ->select('tasks.*, personen.vorname, personen.nachname, taskarten.taskart, taskarten.taskartenicon, spalten.spalte, boards.board, boards.id as boardsid')
            ->join('personen', 'tasks.personenid = personen.id')
            ->join('taskarten', 'tasks.taskartenid = taskarten.id')
            ->join('spalten', 'tasks.spaltenid = spalten.id')
            ->join('boards', 'spalten.boardsid = boards.id')
            ->where('boards.id', $BoardID)
            ->orderBy('tasks.sortid')
            ->get()->getResultArray();
    }

    public function getTasksWithAllNames(): array
    {
        return $this->db->table($this->table)
            ->select('tasks.*, CONCAT(personen.vorname, " ", personen.nachname) as person, taskarten.taskart, taskarten.taskartenicon, spalten.spalte, boards.board')
            ->join('personen', 'tasks.personenid = personen.id')
            ->join('taskarten', 'tasks.taskartenid = taskarten.id')
            ->join('spalten', 'tasks.spaltenid = spalten.id')
            ->join('boards', 'spalten.boardsid = boards.id')
            ->orderBy('tasks.sortid')
            ->get()->getResultArray();
    }


}
