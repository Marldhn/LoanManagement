<h2>Create Loan</h2>

<form method="POST" action="../loan/store">

    <input type="text" name="borrower_name" placeholder="Borrower Name" required><br><br>

    <input type="number" name="amount" placeholder="Amount" required><br><br>

    <input type="number" name="interest" placeholder="Interest %" required><br><br>

    <button type="submit">Save</button>

</form>