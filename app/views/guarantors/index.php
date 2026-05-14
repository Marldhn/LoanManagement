<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Guarantors</h2>

<a href="/LoanManagement/public/index.php?url=guarantor/create">
    Add Guarantor
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
        <th>Name</th>
        <th>Contact</th>
        <th>Address</th>
    </tr>

    <?php if (!empty($guarantors)): ?>
        <?php foreach ($guarantors as $g): ?>
        <tr>
            <td><?= $g['fullname'] ?></td>
            <td><?= $g['contact'] ?></td>
            <td><?= $g['address'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No guarantors found</td>
        </tr>
    <?php endif; ?>

</table>

<?php include __DIR__ . "/../layouts/footer.php"; ?>