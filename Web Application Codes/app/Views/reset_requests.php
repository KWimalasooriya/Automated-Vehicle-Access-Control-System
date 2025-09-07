<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Password Reset Requests</h1>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Action</th>
            </tr>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?= $request['user_id'] ?></td>
                <td><?= $request['username'] ?></td>
                <td><?= ucfirst($request['status']) ?></td>
                <td><?= $request['requested_at'] ?></td>
                <td>
                    <?php if ($request['status'] === 'pending'): ?>
                        <a href="/dashboard/approve-reset/<?= $request['id'] ?>">Reset Password</a> |
                        <a href="/dashboard/reject-request/<?= $request['id'] ?>">Reject</a>
                    <?php else: ?>
                        <?= ucfirst($request['status']) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
