<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Create Loan</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=loan/store">

    <label>Borrower Name</label><br>
    <input type="text" name="borrower_name" placeholder="Borrower Name" required>
    <br><br>

    <label>Amount</label><br>
    <input type="number" name="amount" placeholder="Amount" required>
    <br><br>

    <label>Interest (%)</label><br>
    <input type="number" name="interest" placeholder="Interest %" required>
    <br><br>

    <button type="submit">Save Loan</button>

</form>

<?php include __DIR__ . "/../layouts/footer.php"; ?>