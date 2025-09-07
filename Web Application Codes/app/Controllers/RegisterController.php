<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserPrivilegeModel;
use CodeIgniter\Controller;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register'); // Load the registration view
    }

    public function submit()
    {
        $userModel = new UserModel();
        $privilegeModel = new UserPrivilegeModel();

        // Get form data
        $name = $this->request->getPost('name');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password'); // DO NOT hash here, handled in UserModel
        $role = $this->request->getPost('role');
        $privileges = $this->request->getPost('privileges');

        // Insert user data into the database
        $userId = $userModel->insert([
            'name'     => $name,
            'username' => $username,
            'password' => $password, // Password will be hashed in UserModel
            'role'     => $role
        ]);

        // Store Privileges in `user_privileges` table
        if ($userId && !empty($privileges)) {
            foreach ($privileges as $privilege) {
                $privilegeModel->insert([
                    'user_id'   => $userId,
                    'privilege' => $privilege
                ]);
            }
        }

        return redirect()->to('/login')->with('success', 'Registration successful!');
    }
}
