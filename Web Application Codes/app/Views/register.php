<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Checkboxes */
        .checkbox-group {
            margin-top: 10px;
        }

        .checkbox-group label {
            font-weight: normal;
            display: flex;
            align-items: center;
            font-size: 14px;
            cursor: pointer;
        }

        .checkbox-group input {
            margin-right: 10px;
        }

        /* Flash messages */
        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            background-color: #ffdddd;
            color: #d8000c;
        }

        .success {
            background-color: #ddffdd;
            color: #4CAF50;
        }

        /* Button */
        button {
            width: 100%;
            background: #660097;
            color: white;
            padding: 10px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #660096;
        }

        /* Responsive */
        @media (max-width: 500px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Register</h1>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="/register/submit" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="role">Role:</label>
            <select name="role">
                <option value="SuperAdmin">SuperAdmin</option>
                <option value="Welfare Branch Staff">Welfare Branch Staff</option>
                <option value="Dean">Dean</option>
                <option value="Marshal Office">Marshal Office</option>
                <option value="Security Officer">Security Officer</option>
            </select>

            <h3>Privileges</h3>
            <div class="checkbox-group">
                <label><input type="checkbox" name="privileges[]" value="scan_number_plate"> Scan Number Plate</label>
                <label><input type="checkbox" name="privileges[]" value="issue_gate_pass"> Issue Gate Pass</label>
                <label><input type="checkbox" name="privileges[]" value="view_vehicles_inside"> View Vehicles Inside</label>
                <label><input type="checkbox" name="privileges[]" value="add_vehicle_user"> Add Vehicle User</label>
                <label><input type="checkbox" name="privileges[]" value="manage_users"> Manage Users</label>
                <label><input type="checkbox" name="privileges[]" value="register_user"> Register User</label>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>
