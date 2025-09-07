<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles</title>
</head>
<body>
    <h1>Vehicles</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Number Plate</th>
                <th>Status</th>
                <th>Authorized</th>
                <th>Owner</th>
                <th>Post</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?= esc($vehicle['id']) ?></td>
                    <td><?= esc($vehicle['number_plate']) ?></td>
                    <td><?= esc($vehicle['status']) ?></td>
                    <td><?= esc($vehicle['authorized']) ?></td>
                    <td><?= esc($vehicle['user_id']) ?></td>
                    <td><?= esc($vehicle['post']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
