<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'number_plate', 'contact', 'purpose', 'registered_at'];
}
