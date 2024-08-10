<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wszystkie Konwersje</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<button onclick="window.location='index.php';">Powrót do strony głównej</button>
<h1>Wszystkie Konwersje</h1>
    <table>
        <thead>
            <tr>
                <th>Od</th>
                <th>Do</th>
                <th>Kwota</th>
                <th>Skonwertowana Kwota</th>
                <th>Kurs</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conversions as $conversion): ?>
            <tr>
                <td><?= htmlspecialchars($conversion['from_currency']) ?></td>
                <td><?= htmlspecialchars($conversion['to_currency']) ?></td>
                <td><?= number_format($conversion['amount'], 2) ?></td>
                <td><?= number_format($conversion['converted_amount'], 2) ?></td>
                <td><?= number_format($conversion['conversion_rate'], 4) ?></td>
                <td><?= htmlspecialchars($conversion['timestamp']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
