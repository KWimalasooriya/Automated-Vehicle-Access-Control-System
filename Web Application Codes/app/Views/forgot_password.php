<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select, button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        button {
            background-color: #660097;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #520078;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .message.success {
            background-color: #e0ffe0;
            color: #006400;
        }

        .message.error {
            background-color: #ffe0e0;
            color: #8b0000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>

    <!-- Display success message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="message success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="message error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/forgot-password/request" method="post">
        <!-- Name Input -->
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter your name" required>

        <!-- Username Input -->
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>

        <!-- Role Dropdown -->
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="SuperAdmin">SuperAdmin</option>
            <option value="Welfare Branch Staff">Welfare Branch Staff</option>
            <option value="Dean">Dean</option>
            <option value="Marshal Office">Marshal Office</option>
            <option value="Security Officer">Security Officer</option>
        </select>

        <!-- New Password Input -->
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" placeholder="Enter new password" required>

        <!-- Submit Button -->
        <button type="submit">Sent request to reset Password</button>
    </form>

    <p style="text-align: center; margin-top: 10px;">
        <a href="/login" style="color: #660097; text-decoration: none;">Back to Login</a>
    </p>
</div>

</body>
</html>
