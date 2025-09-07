<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class DBcheck_controller extends Controller
{
    public function index()
    {
        try {
            // Attempt to connect to the database
            $db = \Config\Database::connect();

            // If connected successfully
            if ($db->connect()) {
                return view('db_check', ['status' => 'Connected to the database successfully!']);
            }
        } catch (DatabaseException $e) {
            // If there's an error, display it
            return view('db_check', ['status' => 'Database connection failed: ' . $e->getMessage()]);
        }
    }
}
