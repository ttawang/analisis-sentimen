<?php

namespace App\Models;

use CodeIgniter\Model;

class stopwordlist extends Model
{
    protected $table      = 'stopwordlist';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['kata'];
}
