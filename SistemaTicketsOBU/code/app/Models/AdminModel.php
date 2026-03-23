<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'university_code',
        'dni',
        'nombre',
        'perfil'
    ];
}
