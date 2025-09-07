<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Logs</title>
</head>
<body>
    <h1>Vehicle Logs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle ID</th>
                <th>Entry Time</th>
                <th>Exit Time</th>
                <th>Direction</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= esc($log['id']) ?></td>
                    <td><?= esc($log['vehicle_id']) ?></td>
                    <td><?= esc($log['entry_time']) ?></td>
                    <td><?= esc($log['exit_time']) ?></td>
                    <td><?= esc($log['direction']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
