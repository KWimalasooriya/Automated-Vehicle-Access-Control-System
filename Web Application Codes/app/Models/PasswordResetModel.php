<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table = 'password_reset_requests'; // Table name in the database
    protected $primaryKey = 'id'; // Primary key column

    // Fields that can be inserted or updated
    protected $allowedFields = [
        'user_id',
        'name',
        'username',
        'role',
        'new_password',
        'status',
        'requested_at',
        'handled_at',
        'handled_by'
    ];

    // Disable automatic timestamps
    protected $useTimestamps = false;
}
