<?php

namespace App\Models;

use CodeIgniter\Model;

class GatePassModel extends Model
{
    protected $table = 'gate_passes'; // Your table name for gate passes
    protected $primaryKey = 'id'; // Primary key for the table
    protected $allowedFields = ['number_plate', 'owner_name', 'purpose', 'expiry_time', 'status'];

    // You can add other methods or custom validation if needed
}
