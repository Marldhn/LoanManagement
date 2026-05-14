<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Edit Borrower</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=borrower/update">

    <input type="hidden" name="id" value="<?= $borrower['id'] ?>">

    <input type="text" name="fullname" value="<?= $borrower['fullname'] ?>" required><br><br>

    <input type="text" name="contact" value="<?= $borrower['contact'] ?>" required><br><br>

    <input type="text" name="address" value="<?= $borrower['address'] ?>" required><br><br>

    <button type="submit">Update</button>

</form>

<?php include __DIR__ . "/../layouts/footer.php"; ?>