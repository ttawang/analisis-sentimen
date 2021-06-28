<?php

namespace App\Models;

use CodeIgniter\Model;

class k extends Model
{
    protected $table      = 'k';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['k'];
}
