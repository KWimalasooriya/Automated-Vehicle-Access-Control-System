<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            text-align: center;
            padding: 50px;
        }

        .container {
            background-color: white;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            width: 100%;
            background-color: #660097;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #520078;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Visitor Registration</h2>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <form action="/dashboard/register-visitor-submit" method="post">
        <input type="text" name="name" placeholder="Visitor Name" required>
        <input type="text" name="license_plate" placeholder="License Plate Number" required>
        <input type="text" name="contact" placeholder="Contact Number" required>
        <textarea name="purpose" placeholder="Purpose of Visit" required></textarea>
        <button type="submit">Register</button>
    </form>

    <p><a href="/dashboard">Back to Dashboard</a></p>
</div>

</body>
</html>
