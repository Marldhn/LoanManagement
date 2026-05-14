<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Create Account</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=account/store">

    <label>Account Name</label><br>
    <input type="text" name="account_name" placeholder="Account Name" required>
    <br><br>

    <label>Balance</label><br>
    <input type="number" name="balance" placeholder="Balance" required>
    <br><br>

    <label>Description</label><br>
    <input type="text" name="description" placeholder="Description" required>
    <br><br>

    <button type="submit">Save</button>

</form>
