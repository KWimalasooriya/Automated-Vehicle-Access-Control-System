<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $excludedRoutes = ['login', 'authenticate']; // Allow login routes

        $uri = service('uri')->getSegment(1); // Get the first URI segment

        // Debugging session data
        log_message('info', 'Session Data in Filter: ' . print_r($session->get(), true));

        // Ensure the session key matches the one set in `Login_controller.php`
        if (!in_array($uri, $excludedRoutes) && !$session->has('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Access denied. Please log in.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request processing
    }
}
