<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Account List</h2>

<a href="/LoanManagement/public/index.php?url=account/create">
    Add Account
</a>

<a href="/LoanManagement/public/index.php?url=account/transferForm">
    Transfer Funds
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Account Name</th>
        <th>Balance</th>
        <th>Description</th>
    </tr>

    <?php if (!empty($accounts)): ?>
        <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= $account['account_name'] ?></td>
            <td><?= $account['balance'] ?></td>
            <td><?= $account['description'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No accounts found</td>
        </tr>
    <?php endif; ?>

</table>

<?php include __DIR__ . "/../layouts/footer.php"; ?>