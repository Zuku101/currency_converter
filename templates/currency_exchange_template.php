<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wymiennik walut</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/style.js"></script>
</head>
<body>
    <h1>Wymiennik walut</h1>
    <form action="index.php" method="post">
        <div>
            <label for="from">Z:</label>
            <select name="from" id="from">
    <?php foreach ($currencies as $currency) {
        $isSelected = $currency['code'] === $selectedFrom ? 'selected' : '';
        echo "<option value='{$currency['code']}' $isSelected>{$currency['name']} ({$currency['code']})</option>";
    } ?>
</select>
<button type="button" id="swapButton" onclick="swapCurrencies()" aria-label="Swap currencies">
    <i class="fas fa-exchange-alt"></i>
</button>
            <label for="to">Do:</label>
            <select name="to" id="to">
    <?php foreach ($currencies as $currency) {
        $isSelected = $currency['code'] === $selectedTo ? 'selected' : '';
        echo "<option value='{$currency['code']}' $isSelected>{$currency['name']} ({$currency['code']})</option>";
    } ?>
</select>
        </div>
        <div>
            <label for="amount">Kwota:</label>
            <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>">
            <button type="submit" name="convert">Konwertuj</button>
        </div>
        <?php if ($errorMsg): ?>
            <p style="color: red;"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
    </form>

    <div class="table-container">
    <h2>Ostatnie konwersje:</h2>
    <table>
        <thead>
            <tr>
                <th>Nr</th>
                <th>Od</th>
                <th>Do</th>
                <th>Kwota</th>
                <th>Skonwertowana kwota</th>
                <th>Kurs</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; foreach ($_SESSION['conversions'] as $conversion): ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo htmlspecialchars($conversion['from_currency']); ?></td>
                <td><?php echo htmlspecialchars($conversion['to_currency']); ?></td>
                <td><?php echo number_format($conversion['amount'], 2, '.', ''); ?></td>
                <td><?php echo number_format($conversion['converted_amount'], 2, '.', ''); ?></td>
                <td><?php echo number_format($conversion['conversion_rate'], 4, '.', ''); ?></td>
                <td><?php echo htmlspecialchars($conversion['timestamp']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>

        <form action="index.php" method="post">
    <button type="submit" name="clear_history" class="clear-history-button">Wyczyść historię</button>
</form>
    </table>

</div>
<button onclick="window.location.href='all_conversions.php';">Pokaż Wszystkie Konwersje</button>
</body>
</html>
