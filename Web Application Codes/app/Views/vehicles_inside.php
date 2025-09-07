<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles Inside</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        header {
            background-color: #7851A9;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 24px;
            margin-bottom: 20px;
        }

        main {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            text-align: center;
        }

        .message {
            font-size: 18px;
            color: #f44336;
            text-align: center;
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
            font-size: 16px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
            font-size: 16px;
            text-align: center;
        }

        .btn:hover {
            background-color: #660096;
        }

        @media (max-width: 768px) {
            header {
                font-size: 20px;
            }

            table {
                font-size: 14px;
            }

            .message, h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

<header>
    Vehicles Inside Premises
</header>

<main>
    <?php if (isset($message)): ?>
        <p class="message"><?= $message ?></p>
    <?php else: ?>
        <h1>Currently Inside Vehicles</h1>
        <table>
            <thead>
                <tr>
                    <th>Number Plate</th>
                    <th>Authourization</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= $vehicle['number_plate'] ?></td>
                        <td><?= $vehicle['authorized'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="button-container">
        <a href="/dashboard" class="btn">Back to Dashboard</a>
    </div>
</main>

</body>
</html>
