<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>

    body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}


.borrower-card {
    background: #2c3e50;
    color: white;
    padding: 20px;
    border-radius: 10px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.borrower-card .row {
    display: flex;
    justify-content: space-between;
    padding: 12px 10px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.borrower-card .row:last-child {
    border-bottom: none;
}

.borrower-card .label {
    font-weight: bold;
    opacity: 0.8;
}

.borrower-card .value {
    font-weight: 500;
}

.details-page {
    font-family: Arial, sans-serif;
    color: #2c3e50;
}

.details-page h2 {
    margin-bottom: 10px;
}

.details-page h3 {
    margin-top: 25px;
}

/* Tables */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

table th {
    background: #2c3e50;
    color: white;
    padding: 12px;
    text-align: left;
}

table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

table tr:hover {
    background: #f8f9fa;
}

/* Button link */
.back-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 8px 12px;
    background: #2c3e50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.back-btn:hover {
    background: #34495e;
}
</style>

<div class="details-page">

<h2>Borrower Details</h2>

<br>

<div class="borrower-card">

    <div class="row">
        <span class="label">Full Name</span>
        <span class="value"><?= htmlspecialchars($borrower['fullname']) ?></span>
    </div>

    <div class="row">
        <span class="label">Contact</span>
        <span class="value"><?= htmlspecialchars($borrower['contact']) ?></span>
    </div>

    <div class="row">
        <span class="label">Address</span>
        <span class="value"><?= htmlspecialchars($borrower['address']) ?></span>
    </div>

</div>

<br><br>

<h3>Loan History</h3>

<table border="1" cellpadding="10">

    <tr>
        <th>Loan ID</th>
        <th>Accounts Used</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Total</th>
        <th>Penalty</th>
        <th>Date of Loan</th>
    </tr>

    <?php if (!empty($loans)): ?>

        <?php foreach ($loans as $loan): ?>

        <tr>
            <td><?= $loan['id'] ?></td>

            <td><?= $loan['account_names'] ?></td>

            <td>₱<?= number_format($loan['amount'], 2) ?></td>

            <td><?= $loan['interest'] ?>%</td>

            <td>₱<?= number_format($loan['total'], 2) ?></td>

            <td>₱<?= number_format($loan['total_penalty'] ?? 0, 2) ?></td>

            <td><?= $loan['borrowed_date'] ?></td>
        </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="7">No loan history found</td>
        </tr>

    <?php endif; ?>

</table>

<br>

<a class="back-btn" href="/LoanManagement/public/index.php?url=borrower/index">
    Back
</a>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>