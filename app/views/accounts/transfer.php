<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Transfer Funds</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=account/transferStore">
    <label>From Account</label><br>
    <select name="from_account" required>

        <?php foreach ($accounts as $a): ?>
            <option value="<?= $a['id'] ?>">
                <?= $a['account_name'] ?> (₱<?= $a['balance'] ?>)
            </option>
        <?php endforeach; ?>

    </select>

    <br><br>

    <label>To Account</label><br>
    <select name="to_account" required>

        <?php foreach ($accounts as $a): ?>
            <option value="<?= $a['id'] ?>">
                <?= $a['account_name'] ?> (₱<?= $a['balance'] ?>)
            </option>
        <?php endforeach; ?>

    </select>

    <br><br>

    <label>Amount</label><br>
    <input type="number" name="amount" required>

    <br><br>

    <button type="submit">Transfer</button>

</form>

<?php include __DIR__ . "/../layouts/footer.php"; ?>