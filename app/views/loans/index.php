<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Loan List</h2>

<a href="/LoanManagement/public/index.php?url=loan/create">
    Add Loan
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Borrower</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Total</th>
    </tr>

    <?php if (!empty($loans)): ?>

        <?php foreach ($loans as $loan): ?>
        <tr>
            <td><?= $loan['borrower_name'] ?></td>
            <td><?= $loan['amount'] ?></td>
            <td><?= $loan['interest'] ?>%</td>
            <td><?= $loan['total'] ?></td>
        </tr>
        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="4">No loans found</td>
        </tr>

    <?php endif; ?>

</table>

<?php include __DIR__ . "/../layouts/footer.php"; ?>