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
        $result = $this->db->query(
            'SELECT t.id as id, p.vorname as vorname, p.nachname as nachname, ta.taskart as taskart, 
                s.spalte as spalte, t.personenid as personenid, t.taskartenid as taskartenid, t.spaltenid as spaltenid, 
                t.sortid as sortid, t.tasks as tasks, t.erstelldatum as erstelldatum, t.erinnerungsdatum as erinnerungsdatum, 
                t.erinnerung as erinnerung, t.notizen as notizen, t.erledigt as erledigt, t.geloescht as geloescht
                FROM tasks t
                JOIN personen p ON t.personenid = p.id
                JOIN taskarten ta ON t.taskartenid = ta.id
                JOIN spalten s ON t.spaltenid = s.id');
        return $result->getResultArray();
    }

    public function getTasksFromBoard(string $BoardID): array
    {
        $result = $this->db->query(
            'SELECT t.id as id, p.vorname as vorname, p.nachname as nachname, ta.taskart as taskart, 
                s.spalte as spalte, t.personenid as personenid, t.taskartenid as taskartenid, t.spaltenid as spaltenid, 
                t.sortid as sortid, t.tasks as tasks, t.erstelldatum as erstelldatum, t.erinnerungsdatum as erinnerungsdatum, 
                t.erinnerung as erinnerung, t.notizen as notizen, t.erledigt as erledigt, t.geloescht as geloescht
                FROM tasks t
                JOIN personen p ON t.personenid = p.id
                JOIN taskarten ta ON t.taskartenid = ta.id
                JOIN spalten s ON t.spaltenid = s.id
                JOIN boards b ON s.boardsid = b.id
                WHERE s.boardsid = b.id
                  AND b.id = ?
                ORDER BY t.tasks DESC',
                [$BoardID]);
        return $result->getResultArray();
    }


}
