<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Borrowers</h2>

<a href="/LoanManagement/public/index.php?url=borrower/create">
    Add Borrower
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
    </tr>

    <?php if (!empty($borrowers)): ?>
        <?php foreach ($borrowers as $b): ?>
        <tr>
            <td><?= $b['fullname'] ?></td>
            <td><?= $b['contact'] ?></td>
            <td><?= $b['address'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No borrowers found</td>
        </tr>
    <?php endif; ?>

</table>

<?php include __DIR__ . "/../layouts/footer.php"; ?>