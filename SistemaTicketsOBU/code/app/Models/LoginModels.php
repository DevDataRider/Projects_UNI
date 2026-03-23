<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModels extends Model {

    protected $table = "students";
    protected $primaryKey = "id";

    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'full_name', 'dni', 'university_code', 'email_institutional', 
        'mobile', 'gender', 'is_scholarship', 'password'
    ];
}
