<?php

namespace App\Models;

use CodeIgniter\Model;

class tweet extends Model
{
    protected $table      = 'tweet';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['kalimat','tanggal','ket'];
    
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    
}
