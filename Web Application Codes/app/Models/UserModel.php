<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'username', 'password', 'role'];

    // Validation rules
    protected $validationRules = [
        'username' => 'required|is_unique[users.username]',
        'password' => 'required|min_length[6]',
    ];

    // Before insert or update, hash the password
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Hash the password before saving
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            // Ensure the password is hashed before saving
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Fetch user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
