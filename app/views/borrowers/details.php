<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Borrower Details</h2>

<br>

<table border="1" cellpadding="10">

    <tr>
        <th>Full Name</th>
        <td><?= $borrower['fullname'] ?></td>
    </tr>

    <tr>
        <th>Contact</th>
        <td><?= $borrower['contact'] ?></td>
    </tr>

    <tr>
        <th>Address</th>
        <td><?= $borrower['address'] ?></td>
    </tr>

</table>

<br><br>

<h3>Loan History</h3>

<table border="1" cellpadding="10" width="100%">

    <tr>
        <th>Loan ID</th>
        <th>Accounts Used</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Total</th>
        <th>Date of Loan</th>

    </tr>

    <?php if (!empty($loans)): ?>

        <?php foreach ($loans as $loan): ?>

        <tr>

            <td><?= $loan['id'] ?></td>

            <td><?= $loan['account_names'] ?></td>

            <td>
                ₱<?= number_format($loan['amount'], 2) ?>
            </td>

            <td>
                <?= $loan['interest'] ?>%
            </td>

            <td>
                ₱<?= number_format($loan['total'], 2) ?>
            </td>


            <td><?= $loan['borrowed_date'] ?></td>

        </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="5">
                No loan history found
            </td>
        </tr>

    <?php endif; ?>

</table>

<br>

<a href="/LoanManagement/public/index.php?url=borrower/index">
    Back
</a>

<?php include __DIR__ . "/../layouts/footer.php"; ?>