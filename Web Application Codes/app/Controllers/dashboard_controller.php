<?php

namespace App\Controllers;
use CodeIgniter\Controller;

use App\Models\VehicleModel;
use App\Models\GatePassModel;
use App\Models\UserPrivilegeModel; // Add this line
use App\Models\PasswordResetModel;

class Dashboard_controller extends Controller
{
    public function index()
    {
        return view('dashboard'); // Show the dashboard
    }

    public function scanNumberPlate()
{
    $request = service('request');
    $plateNumber = strtoupper($request->getPost('number_plate')); // Convert input to uppercase

    $vehicleModel = new \App\Models\VehicleModel();
    $visitorModel = new \App\Models\VisitorModel();

    // Step 1: Check if the number plate belongs to a registered vehicle
    $vehicle = $vehicleModel->where('number_plate', $plateNumber)->first();

    if ($vehicle) {
        return view('dashboard', ['vehicle' => $vehicle]); // Fixed view path
    }

    // Step 2: Check if the number plate belongs to a pre-registered visitor
    $visitor = $visitorModel->where('number_plate', $plateNumber)->first();

    if ($visitor) {
        return view('dashboard', ['visitor' => $visitor]); // Fixed view path
    }

    // Step 3: If no record is found, treat it as an unknown visitor
    $unknownVisitor = [
        'number_plate' => $plateNumber,
        'name'         => 'Unknown',
        'post'         => 'Visitor',
        'authorized'   => 'No'
    ];

    return view('dashboard', ['vehicle' => $unknownVisitor]); // Fixed view path
}



    public function issueGatePassForm()
    {
        return view('gatePassForm'); // Display the form for issuing a gate pass
    }

    public function issueGatePass()
    {
        $request = service('request');
        $gatePassModel = new GatePassModel();
    
        // Get data from the form
        $numberPlate = $request->getPost('number_plate');
        $ownerName = $request->getPost('owner_name');
        $purpose = $request->getPost('purpose');
    
        // Set the expiry time to 24 hours from now
        $expiryTime = date('Y-m-d H:i:s', strtotime('+1 day'));
    
        // Prepare data for saving
        $gatePassData = [
            'number_plate' => $numberPlate,
            'owner_name'   => $ownerName,
            'purpose'      => $purpose,
            'expiry_time'  => $expiryTime,
            'status'       => 'active', // default status
        ];
    
        try {
            // Attempt to save the gate pass
            if ($gatePassModel->save($gatePassData)) {
                return redirect()->to('/dashboard')->with('success', 'Gate pass issued successfully!');
            } else {
                echo "<script>alert('Error issuing gate pass. Please try again.'); window.location.href='/dashboard/issueGatePassForm';</script>";
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            // Check if the error is related to foreign key constraint
            if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                echo "<script>alert('Vehicle not found in the database. Please scan or add the vehicle first.'); window.location.href='/dashboard/issueGatePassForm';</script>";
            } else {
                // For other exceptions, return a generic error message
                echo "<script>alert('An unexpected error occurred: " . addslashes($e->getMessage()) . "'); window.location.href='/dashboard/issueGatePassForm';</script>";
            }
        }
    }

    public function vehiclesInside()
{
    $db = \Config\Database::connect();
    $query = $db->query("
        SELECT v.number_plate, v.authorized, v.post, vl.entry_time, vl.exit_time, vl.status
        FROM vehicles v
        JOIN vehicle_logs vl ON v.id = vl.vehicle_id
        WHERE vl.status = 'Inside'
        ORDER BY vl.entry_time DESC
    ");

    $vehicles = $query->getResultArray();

    if (empty($vehicles)) {
        return view('vehicles_inside', ['message' => 'No vehicles are currently inside the premises.']);
    }

    return view('vehicles_inside', ['vehicles' => $vehicles]);
}




    public function searchVehicles()
    {
        $request = service('request');
        $vehicleModel = new VehicleModel();

        // Get the search query
        $licensePlate = $request->getGet('number_plate');

        // Search for vehicles matching the license plate
        $vehicles = $vehicleModel
            ->like('number_plate', $licensePlate)
            ->where('status', 'inside')
            ->findAll();

        return view('vehicles_inside', ['vehicles' => $vehicles]);
    }

    public function addVehicleUserForm()
{
    return view('add_vehicle_user');
}

public function saveVehicleUser()
{
    $db = \Config\Database::connect();

    $name = $this->request->getPost('name');
    $post = $this->request->getPost('post');
    $contact = $this->request->getPost('contact');
    $email = $this->request->getPost('email');
    $number_plate = $this->request->getPost('number_plate');

    // Check if number plate already exists in vehicle_users table (not vehicles)
    $query = $db->query("SELECT * FROM vehicle_users WHERE number_plate = ?", [$number_plate]);
    $existingVehicleUser = $query->getRowArray();

    if ($existingVehicleUser) {
        return view('add_vehicle_user', ['error' => 'This number plate is already registered in vehicle users!']);
    }

    // Insert into vehicle_users table ONLY (DO NOT UPDATE vehicles table)
    $db->query("INSERT INTO vehicle_users (name, post, contact, email, number_plate) VALUES (?, ?, ?, ?, ?)", 
               [$name, $post, $contact, $email, $number_plate]);

    // Redirect back to dashboard with success message
    return redirect()->to('/dashboard')->with('message', 'Vehicle user registered successfully!');
}


        public function dashboard()
    {
        $privilegeModel = new UserPrivilegeModel();
        $userId = session()->get('user_id');

        // Fetch user's privileges
        $privileges = $privilegeModel->where('user_id', $userId)->findAll();
        
        // Store privileges in session
        $privilegeList = array_column($privileges, 'privilege');
        session()->set('privileges', $privilegeList);

        return view('dashboard');
    }

    public function resetRequests()
    {
        $resetModel = new PasswordResetModel();
        $requests = $resetModel->findAll(); // Fetch all password reset requests

        return view('reset_requests', ['requests' => $requests]);
    }

    public function registerVisitor()
{
    return view('register_visitor');
}

public function registerVisitorSubmit()
{
    $request = service('request');
    $visitorModel = new \App\Models\VisitorModel();

    // Validate input: Ensure number_plate is not null
    $number_plate = trim($request->getPost('number_plate')); // Trim whitespace

    if (empty($number_plate)) {
        return redirect()->to('/dashboard/register-visitor')->with('error', 'Number plate is required.');
    }

    // Convert to uppercase
    $number_plate = strtoupper($number_plate);

    $data = [
        'name' => $request->getPost('name'),
        'number_plate' => $number_plate,
        'contact' => $request->getPost('contact'),
        'purpose' => $request->getPost('purpose'),
    ];

    // Attempt to insert into database
    if ($visitorModel->insert($data)) {
        return redirect()->to('/dashboard/register-visitor')->with('success', 'Visitor registered successfully.');
    } else {
        return redirect()->to('/dashboard/register-visitor')->with('error', 'Registration failed.');
    }
}


public function fetchLatestVehicle()
{
    $vehicleModel = new \App\Models\VehicleModel();

    // Fetch the latest vehicle that is "Inside"
    $latestVehicle = $vehicleModel->where('status', 'Inside')
                                  ->orderBy('entry_time', 'DESC')
                                  ->first();

    if ($latestVehicle) {
        return $this->response->setJSON([
            'success' => true,
            'vehicle' => [
                'number_plate' => $latestVehicle['number_plate'],
                'authorized' => ($latestVehicle['authorized'] === 'TRUE') ? 'Yes' : 'No',
                'status' => $latestVehicle['status'],
                'entry_time' => $latestVehicle['entry_time'],
                'post' => $latestVehicle['post'] ?? 'Unknown',
            ]
        ]);
    } else {
        return $this->response->setJSON(['success' => false]);
    }
}

public function getLatestVehicles()
{
    $db = \Config\Database::connect();
    
    $query = $db->query("
        SELECT v.number_plate, v.authorized, v.user_id, v.post, v.gate_pass_issued,
               vl.entry_time, vl.exit_time, vl.status
        FROM vehicles v
        LEFT JOIN vehicle_logs vl ON v.id = vl.vehicle_id
        ORDER BY vl.entry_time DESC
    ");

    return $query->getResultArray(); 
}




public function latestVehicleData()
{
    $db = \Config\Database::connect();

    // Fetch the latest vehicle data from vehicle_logs and join vehicle_users for post
    $query = $db->query("
        SELECT 
            v.number_plate, 
            COALESCE(vu.post, 'N/A') AS post, 
            COALESCE(vl.authorized, 'NO') AS authorized, 
            vl.entry_time, 
            vl.exit_time, 
            vl.status
        FROM vehicle_logs vl
        JOIN vehicles v ON vl.vehicle_id = v.id
        LEFT JOIN vehicle_users vu ON v.number_plate = vu.number_plate
        ORDER BY vl.entry_time DESC
    ");
    $vehicles = $query->getResultArray();

    // Fetch visitor data for matching license plates
    $visitorQuery = $db->query("
        SELECT name, number_plate, purpose 
        FROM visitors
        WHERE number_plate IN (SELECT number_plate FROM vehicles)
    ");
    $visitors = $visitorQuery->getResultArray();

    return $this->response->setJSON([
        'success' => true,
        'vehicles' => $vehicles ?? [],
        'visitors' => $visitors ?? []
    ]);
}


// Method to fetch the latest vehicle details in the DashboardController
public function latestVehicle()
{
    $vehicleModel = new \App\Models\VehicleModel();
    
    // Get the latest vehicles inside
    $latestVehicles = $vehicleModel->where('status', 'Inside')->findAll();

    return $this->response->setJSON([
        'success' => true,
        'vehicles' => $latestVehicles
    ]);
}





    



}
