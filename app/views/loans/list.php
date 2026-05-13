<h2>Loan List</h2>

<a href="../loan/create">Add Loan</a>

<table border="1">
    <tr>
        <th>Borrower</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Total</th>
    </tr>

    <?php foreach ($loans as $loan): ?>
    <tr>
        <td><?= $loan['borrower_name'] ?></td>
        <td><?= $loan['amount'] ?></td>
        <td><?= $loan['interest'] ?>%</td>
        <td><?= $loan['total'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>