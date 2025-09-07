<!-- In gatePassForm.php view -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Gate Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 20px;
        }

        label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #660097;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #660096;
        }

        a {
            text-decoration: none;
            color: #660097;
            font-size: 14px;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        a:hover {
            color: #660096;
        }
    </style>
</head>
<body>
    <div>
        <h1>Issue Gate Pass</h1>

        <form action="/dashboard/issueGatePass" method="post">
            <label for="number_plate">Number Plate:</label>
            <input type="text" name="number_plate" required><br>

            <label for="owner_name">Owner's Name:</label>
            <input type="text" name="owner_name" required><br>

            <label for="purpose">Purpose of Visit:</label>
            <input type="text" name="purpose" required><br>

            <button type="submit">Issue Gate Pass</button>
        </form>
    </div>
</body>
</html>
