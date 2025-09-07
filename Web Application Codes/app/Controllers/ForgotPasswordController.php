<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('forgot_password'); // Load the forgot password view
    }

    public function requestReset()
    {
        $request = service('request');
    
        // Get form data
        $name = $request->getPost('name');
        $username = $request->getPost('username');
        $role = $request->getPost('role');
        $newPassword = $request->getPost('new_password'); // Keep plain text for now
    
        // Log the password for debugging
        log_message('info', 'New password from form: ' . $newPassword);
    
        // Validate input
        if (empty($name) || empty($username) || empty($role) || empty($newPassword)) {
            return redirect()->to('/forgot-password')->with('error', 'All fields are required.');
        }
    
        $userModel = new UserModel();
    
        // Fetch user details based on the provided data
        $user = $userModel->where('name', $name)
                          ->where('username', $username)
                          ->where('role', $role)
                          ->first();
    
        if (!$user) {
            // User not found
            return redirect()->to('/forgot-password')->with('error', 'User not found or details do not match.');
        }
    
        $resetModel = new \App\Models\PasswordResetModel();
    
        // Insert the reset request into the database
        $resetModel->insert([
            'user_id' => $user['id'],
            'name' => $name,
            'username' => $username,
            'role' => $role,
            'new_password' => $newPassword, // Plain text password is stored temporarily
            'status' => 'pending',
        ]);
    
        return redirect()->to('/forgot-password')->with('success', 'Your request has been submitted for approval.');
    }
    

    public function approveReset($id)
    {
        $resetModel = new \App\Models\PasswordResetModel();
        $userModel = new \App\Models\UserModel();
    
        // Fetch the reset request
        $resetRequest = $resetModel->find($id);
    
        if (!$resetRequest || $resetRequest['status'] !== 'pending') {
            return redirect()->to('/dashboard/reset-requests')->with('error', 'Invalid or already handled request.');
        }
    
        // Update the user's password in the users table
        $userModel->update($resetRequest['user_id'], [
            'password' => $resetRequest['new_password'], // The password is already hashed in the reset request
        ]);
    
        // Mark the request as approved in the password_reset_requests table
        $resetModel->update($id, [
            'status' => 'approved',
            'handled_at' => date('Y-m-d H:i:s'),
            'handled_by' => session()->get('id'), // ID of the admin handling the request
        ]);
    
        return redirect()->to('/dashboard/reset-requests')->with('success', 'Password reset successfully.');
    }
    

public function rejectRequest($id)
{
    $resetModel = new \App\Models\PasswordResetModel();

    // Fetch the reset request
    $resetRequest = $resetModel->find($id);

    if (!$resetRequest || $resetRequest['status'] !== 'pending') {
        return redirect()->to('/dashboard/reset-requests')->with('error', 'Invalid or already handled request.');
    }

    // Mark the request as rejected
    $resetModel->update($id, [
        'status' => 'rejected',
        'handled_at' => date('Y-m-d H:i:s'),
        'handled_by' => session()->get('id') // ID of the admin handling the request
    ]);

    return redirect()->to('/dashboard/reset-requests')->with('success', 'Password reset request rejected.');
}


    
}
