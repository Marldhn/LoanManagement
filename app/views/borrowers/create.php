<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Create Borrower</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=borrower/store">

    <label>Full Name</label><br>
    <input type="text" name="fullname" placeholder="Full Name" required>
    <br><br>

    <label>Contact</label><br>
    <input type="text" name="contact" placeholder="Contact" required>
    <br><br>

    <label>Address</label><br>
    <input type="text" name="address" placeholder="Address" required>
    <br><br>

    <button type="submit">Save</button>

</form>
