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

}