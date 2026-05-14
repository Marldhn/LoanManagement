<h2>Account List</h2>

<a href="../account/create">Add Account</a>

<table border="1">
    <tr>
        <th>Account Name</th>
        <th>Balance</th>
        <th>Description</th>
    </tr>

    <?php foreach ($accounts as $account): ?>
    <tr>
        <td><?= $account['account_name'] ?></td>
        <td><?= $account['balance'] ?></td>
        <td><?= $account['description'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
 