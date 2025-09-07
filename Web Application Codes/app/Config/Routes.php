<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Instantiate the route collection service
$routes = Services::routes();

// Load the system's routing file first
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Set default route settings
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login_controller');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Disabling auto-routing

// Define custom routes below

// Login routes
$routes->get('/', 'Home::index');
$routes->get('/db-check', 'DBcheck_controller::index');
$routes->get('/login', 'Login_controller::index'); // Show login page
$routes->post('/authenticate', 'Login_controller::authenticate'); // Handle login form submission
$routes->get('/logout', 'Login_controller::logout'); // Handle logout


// Registration routes
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/submit', 'RegisterController::submit');


// Add more routes here as needed
$routes->get('/dashboard', 'Dashboard_controller::index'); // Show the dashboard page

// Log routes under the dashboard
$routes->get('/dashboard/logs', 'Logs_controller::index'); // List all logs
$routes->get('/dashboard/logs/vehicle/(:num)', 'Logs_controller::vehicleLogs/$1'); // Show logs for a specific vehicle

$routes->post('/dashboard/scan', 'Dashboard_controller::scanNumberPlate'); // Handle scanned number plate
$routes->get('/dashboard/issueGatePassForm', 'Dashboard_controller::issueGatePassForm');
$routes->post('dashboard/issueGatePass', 'Dashboard_controller::issueGatePass');


$routes->get('dashboard/vehiclesInside', 'Dashboard_controller::vehiclesInside');
$routes->get('dashboard/searchVehicles', 'Dashboard_controller::searchVehicles');
$routes->get('dashboard/addVehicleUserForm', 'Dashboard_controller::addVehicleUserForm');
$routes->post('dashboard/saveVehicleUser', 'Dashboard_controller::saveVehicleUser');

// Password reset request by users
$routes->get('/forgot-password', 'ForgotPasswordController::index'); // Show the forgot password page
$routes->post('/forgot-password/request', 'ForgotPasswordController::requestReset'); // Handle the request submission

// Super Admin Password Reset Request Management
$routes->get('/dashboard/reset-requests', 'Dashboard_controller::resetRequests'); // Show all reset requests
$routes->get('/dashboard/reset-password/(:num)', 'ForgotPasswordController::resetPasswordForm/$1'); // Reset Password Form
$routes->get('/dashboard/reject-request/(:num)', 'ForgotPasswordController::rejectRequest/$1'); // Reject request
$routes->post('/dashboard/reset-password', 'ForgotPasswordController::resetPassword'); // Process password reset

// Approve Reset Request
$routes->get('/dashboard/approve-reset/(:num)', 'ForgotPasswordController::approveReset/$1');
// Reject Reset Request
$routes->get('/dashboard/reject-request/(:num)', 'ForgotPasswordController::rejectRequest/$1');

$routes->get('/dashboard/register-visitor', 'Dashboard_controller::registerVisitor');
$routes->post('/dashboard/register-visitor-submit', 'Dashboard_controller::registerVisitorSubmit');
$routes->post('/logout', 'Login_controller::logout');

$routes->get('/dashboard/latest-vehicle', 'Dashboard_controller::getLatestVehicle');
$routes->get('/dashboard/latest-vehicle-data', 'Dashboard_controller::latestVehicleData');









// Ensure this is at the end
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
