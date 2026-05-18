<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial;
    background: #f5f6fa;
}

.container {
    padding: 20px;
}

/* CARD */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
}

th {
    background: #f1f1f1;
}

/* BADGE */
.badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    color: white;
}

.in { background: #28a745; }
.out { background: #dc3545; }
</style>

<div class="container">

<a href="/LoanManagement/public/index.php?url=account/index">
    ⬅ Back to Accounts
</a>
<?php
$total_in = 0;
$total_out = 0;
?>

<div class="card">
    <h2><?= $account['account_name'] ?></h2>

    <p><b>Current Balance:</b> ₱<?= number_format($account['balance'], 2) ?></p>
</div>

<div class="card">
    <h3>Transaction History</h3>

    <table>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Loan ID</th>
            <th>Amount</th>
        </tr>

        <?php foreach ($ledger as $row): ?>

            <?php
                if ($row['type'] === 'PAYMENT') {
                    $total_in += $row['amount'];
                } else {
                    $total_out += $row['amount'];
                }
            ?>

            <tr>
                <td><?= $row['created_at'] ?></td>

                <td>
                    <?php if ($row['type'] === 'PAYMENT'): ?>
                        <span class="badge in">IN</span>
                    <?php else: ?>
                        <span class="badge out">OUT</span>
                    <?php endif; ?>
                </td>

                <td>#<?= $row['loan_id'] ?></td>

                <td>
                    ₱<?= number_format($row['amount'], 2) ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>

<div class="card">
    <h3>Summary</h3>

    <p><b>Total IN:</b> ₱<?= number_format($total_in, 2) ?></p>
    <p><b>Total OUT:</b> ₱<?= number_format($total_out, 2) ?></p>
</div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>