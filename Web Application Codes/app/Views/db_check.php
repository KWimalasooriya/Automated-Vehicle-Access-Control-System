<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .status {
            font-size: 20px;
            color: green;
        }
        .error {
            font-size: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <h1>Database Connection Check</h1>
    <p class="<?= strpos($status, 'failed') !== false ? 'error' : 'status' ?>">
        <?= esc($status) ?>
    </p>
</body>
</html>
