<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            display: flex;
            flex-direction: column;
        }

        /* Header Styling */
        .header {
            background-color: #660097;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .header-content {
            display: flex;
            align-items: center;
            width: 100%;
        }

        

        .logo {
            height: 50px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            font-weight: normal;
            text-align: center;
            flex: 1; /* Centers the title */
        }

        .profile-section {
            display: flex;
            align-items: center;
        }

        .profile-icon {
            height: 40px;
            width: 40px;
            margin-right: 10px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
        }

        .profile-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
        }

        .tooltip {
            visibility: hidden;
            width: 160px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            padding: 8px;
            border-radius: 5px;
            position: absolute;
            z-index: 100;
            top: 50px; /* Position below the profile picture */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            font-size: 14px;
        }

        .profile-container:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }


        .logout-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }


        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 70px; /* Adjust according to header height */
        }

        .sidebar h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #660097;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #660096;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
            margin-top: 90px; /* Adjust according to header height */
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-button {
            background-color: #660097;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 5px;
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .auth-row {
            font-weight: bold;
            text-align: center;
            color: black;
        }

        .authorized {
            background-color: #28a745 !important; /* Green */
            color: white;
        }

        .not-authorized {
            background-color: #dc3545 !important; /* Red */
            color: white;
        }


        /* Footer Styling */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <img src="<?= base_url('assets/images/logo-web.png') ?>" alt="University Logo" class="logo">
            <h1>University Vehicle Management System</h1>
            <div class="profile-section">
    <div class="profile-container">
        <img src="<?= base_url('assets/images/profile.webp') ?>" alt="Profile Icon" class="profile-icon">
        <div class="tooltip">
            <p><strong><?= session()->get('name'); ?></strong></p>
            <p><?= session()->get('role'); ?></p>
        </div>
    </div>
    <form action="/logout" method="POST">
    <button type="submit" class="logout-button">Logout</button>
</form>

</div>


        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="/dashboard/scan">Scan Number Plate</a>
        <a href="/dashboard/issueGatePassForm">Issue Gate Pass</a>
        <a href="/dashboard/vehiclesInside">View Vehicles Inside</a>
        <a href="/dashboard/addVehicleUserForm">Add Vehicle User</a>
        <a href="/dashboard/register-visitor">Register Visitor</a>

        <div class="dropdown">
            <button class="dropdown-button">Manage Users</button>
            <div class="dropdown-content">
                <a href="/register">Register User</a>
                <a href="/dashboard/reset-requests">Password Reset Requests</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
<!-- Main Content -->
<div class="main-content">
    <h1>Latest Vehicle Information</h1>

    <!-- Display Vehicle Table -->
    <div id="vehicle-table">
        <p>Loading...</p>
    </div>

    <!-- Display Visitor Table -->
    <div id="visitor-table">
        <p>Loading...</p>
    </div>
</div>

<!-- Auto Refresh Script -->
<script>
function fetchLatestVehicles() {
    fetch('/dashboard/latest-vehicle-data')
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                document.getElementById('vehicle-table').innerHTML = '<p>No vehicles found.</p>';
                document.getElementById('visitor-table').innerHTML = '<p>No visitors found.</p>';
                return;
            }

            const vehicles = Array.isArray(data.vehicles) ? data.vehicles : [];
            const visitors = Array.isArray(data.visitors) ? data.visitors : [];

            // Generate Vehicle Table
            let vehicleTable = `
                <h2>All Vehicles</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Number Plate</th>
                            <th>Owner's Post</th>
                            <th>Authorized</th>
                            <th>Entry Time</th>
                            <th>Exit Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            vehicles.forEach(vehicle => {
                vehicleTable += `
                    <tr>
                        <td>${vehicle.number_plate}</td>
                        <td>${vehicle.post ?? 'N/A'}</td>
                        <td class="${vehicle.authorized === 'YES' ? 'authorized' : 'not-authorized'}">
                            ${vehicle.authorized}
                        </td>
                        <td>${vehicle.entry_time ?? 'N/A'}</td>
                        <td>${vehicle.exit_time ?? 'N/A'}</td>
                        <td>${vehicle.status ?? 'N/A'}</td>
                    </tr>
                `;
            });
            vehicleTable += `</tbody></table>`;
            document.getElementById('vehicle-table').innerHTML = vehicleTable;

            // Generate Visitor Table
            let visitorTable = `
                <h2>Registered Visitors</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>License Plate</th>
                            <th>Purpose</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            visitors.forEach(visitor => {
                visitorTable += `
                    <tr>
                        <td>${visitor.name}</td>
                        <td>${visitor.license_plate}</td>
                        <td>${visitor.purpose}</td>
                    </tr>
                `;
            });
            visitorTable += `</tbody></table>`;
            document.getElementById('visitor-table').innerHTML = visitorTable;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('vehicle-table').innerHTML = '<p>Error fetching data.</p>';
            document.getElementById('visitor-table').innerHTML = '<p>Error fetching data.</p>';
        });
}

// Auto-refresh data every 5 seconds
setInterval(fetchLatestVehicles, 5000);

</script>






</body>
</html>