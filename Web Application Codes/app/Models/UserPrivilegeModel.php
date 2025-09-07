<?php
namespace App\Models;

use CodeIgniter\Model;

class UserPrivilegeModel extends Model
{
    protected $table = 'user_privileges';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'privilege'];
}
