<?php 
namespace App\Models;

use CodeIgniter\Model;

class test extends Model
{
    protected $table = 'test'; 
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = ['name', 'email','city','status'];
    protected $useTimestamps = false;

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

}