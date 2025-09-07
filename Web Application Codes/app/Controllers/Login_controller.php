<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserPrivilegeModel;
use CodeIgniter\Controller;

class Login_controller extends Controller
{
    // Show the login page
    public function index()
    {
        return view('login'); // Load the login page
    }

    // Authenticate the user during login
    public function authenticate()
    {
        $session = session();
        $request = service('request');
        $model = new UserModel();
        $privilegeModel = new UserPrivilegeModel();
    
        $username = $request->getPost('username');
        $password = $request->getPost('password');
    
        // Retrieve user from the database
        $user = $model->where('username', $username)->first();
    
        if ($user) {
            log_message('info', 'Stored Hashed Password from DB: ' . $user['password']);
            log_message('info', 'Entered Password: ' . $password);
    
            // Verify password
            if (password_verify($password, $user['password'])) {
                log_message('info', 'Password Verification Result: SUCCESS');
    
                // Fetch user privileges
                $privileges = $privilegeModel->where('user_id', $user['id'])->findAll();
                $privilegeList = $privileges ? array_column($privileges, 'privilege') : [];
    
                // Store user session
                $session->set([
                    'id'         => $user['id'],
                    'name'       => $user['name'],
                    'role'       => $user['role'],
                    'privileges' => $privilegeList,
                    'isLoggedIn' => true,
                ]);
    
                return redirect()->to('/dashboard')->with('success', 'Login successful.');
            } else {
                log_message('error', 'Password mismatch for user: ' . $username);
                return redirect()->back()->with('error', 'Invalid password.');
            }
        } else {
            log_message('error', 'User not found: ' . $username);
            return redirect()->back()->with('error', 'User not found.');
        }
    }
    
    
    
    

    // Logout the user and destroy the session
    public function logout()
{
    $session = session();
    $session->destroy(); // Completely destroy the session

    return redirect()->to('/login')->with('success', 'You have been logged out.');
}


    // Show the registration page
    public function register()
    {
        return view('register'); // Load the register page
    }

    // Handle registration logic


}
