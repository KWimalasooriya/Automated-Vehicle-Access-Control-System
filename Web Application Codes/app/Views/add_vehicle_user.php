<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle User</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7fc; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 5px; width: 400px; margin: auto; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 15px; padding: 10px 15px; background-color: #660097; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #660096; }
    </style>
</head>
<body>

<h1>Add New Vehicle User</h1>

<!-- Error Message -->
<?php if (isset($error) && $error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="/dashboard/saveVehicleUser" method="POST">
    <label for="name">Owner's Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="post">Post:</label>
    <input type="text" id="post" name="post" required>

    <label for="contact">Contact:</label>
    <input type="text" id="contact" name="contact" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="number_plate">Number Plate:</label>
    <input type="text" id="number_plate" name="number_plate" required>

    <button type="submit">Register Vehicle User</button>
</form>

</body>
</html>
