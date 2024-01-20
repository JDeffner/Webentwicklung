<?php namespace App\Models;
use CodeIgniter\Model;
class Tasks extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $allowedFields = ['sortid', 'tasks', 'erinnerungsdatum', 'erinnerung', 'notizen',
        'erledigt', 'geloescht', 'personenid', 'taskartenid', 'spaltenid'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'erstelldatum';
    protected $updatedField = '';
    public function getAllData()
    {
        return $this->db->table('tasks')
            ->select('tasks.id, personen.vorname, personen.nachname, taskarten.taskart, spalten.spalte, tasks.personenid, tasks.taskartenid, tasks.spaltenid, tasks.sortid, tasks.tasks, tasks.erstelldatum, tasks.erinnerungsdatum, tasks.erinnerung, tasks.notizen, tasks.erledigt, tasks.geloescht')
            ->join('personen', 'tasks.personenid = personen.id')
            ->join('taskarten', 'tasks.taskartenid = taskarten.id')
            ->join('spalten', 'tasks.spaltenid = spalten.id')
            ->get()->getResultArray();
    }

    public function getTasksFromBoard(string $BoardID): array
    {
        return $this->db->table('tasks')
            ->select('tasks.id, personen.vorname, personen.nachname, taskarten.taskart, spalten.spalte, tasks.personenid, tasks.taskartenid, tasks.spaltenid, tasks.sortid, tasks.tasks, tasks.erstelldatum, tasks.erinnerungsdatum, tasks.erinnerung, tasks.notizen, tasks.erledigt, tasks.geloescht')
            ->join('personen', 'tasks.personenid = personen.id')
            ->join('taskarten', 'tasks.taskartenid = taskarten.id')
            ->join('spalten', 'tasks.spaltenid = spalten.id')
            ->join('boards', 'spalten.boardsid = boards.id')
            ->where('boards.id', $BoardID)
            ->orderBy('tasks.tasks', 'DESC')
            ->get()->getResultArray();
    }


}
