<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

.container {
    max-width: 750px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
}

h2 {
    margin-bottom: 15px;
}

label {
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.row {
    display: flex;
    gap: 10px;
    align-items: center;
}

.row > div {
    flex: 1;
}

/* BUTTONS */
button {
    padding: 10px 15px;
    border: none;
    background: #3498db;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #2980b9;
}

.remove-btn {
    background: #e74c3c;
    padding: 8px 10px;
    border-radius: 5px;
    color: white;
    border: none;
}

.remove-btn:hover {
    background: #c0392b;
}

/* SUMMARY BOX */
.summary {
    background: #f1f1f1;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}
</style>

<div class="container">

<h2>Create Loan</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=loan/store">

    <!-- BORROWER -->
    <label>Borrower</label>
    <select name="borrower_id" required>
        <option value="">Select Borrower</option>
        <?php foreach ($borrowers as $borrower): ?>
            <option value="<?= $borrower['id'] ?>">
                <?= $borrower['fullname'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- GUARANTOR -->
    <label>Guarantor (Optional)</label>
    <select name="guarantor_id">
        <option value="">No Guarantor</option>
        <?php foreach ($guarantors as $g): ?>
            <option value="<?= $g['id'] ?>">
                <?= $g['fullname'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="row">
        <div>
            <label>Date Borrowed</label>
            <input type="date" name="borrowed_date" required>
        </div>

        <div>
            <label>Loan Term (Days)</label>
            <input type="number" name="days" required>
        </div>
    </div>

    <!-- LOAN AMOUNT -->
    <label>Loan Amount</label>
    <input type="number" id="amount" name="amount" required oninput="calculateAll()">

    <!-- INTEREST -->
    <label>Interest (%)</label>
    <input type="number" id="interest" name="interest" required oninput="calculateAll()">

    <!-- SUMMARY -->
    <div class="summary">
        <p>Interest Amount: <b>₱<span id="interest_amount">0.00</span></b></p>
        <p>Total Payable: <b>₱<span id="total_payable">0.00</span></b></p>
        <hr>
        <p>Remaining Funding: <b>₱<span id="remaining_funding">0.00</span></b></p>
    </div>

    <!-- FUNDING -->
    <label>Funding Accounts</label>

    <div id="account-wrapper">

        <div class="row account-row">

            <div>
                <select name="account_id[]" required>
                    <option value="">Select Account</option>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?= $account['id'] ?>">
                            <?= $account['account_name'] ?> (₱<?= number_format($account['balance'],2) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <input type="number"
                       name="account_amount[]"
                       class="account_amount"
                       placeholder="Amount"
                       required
                       oninput="calculateAll()">
            </div>

            <button type="button" class="remove-btn" onclick="removeRow(this)">X</button>

        </div>

    </div>

    <br>

    <button type="button" onclick="addAccountRow()">+ Add Account</button>

    <br><br>

    <button type="submit">Save Loan</button>

</form>

</div>

<script>

function calculateAll() {

    // ---------------- LOAN + INTEREST ----------------
    let amount = parseFloat(document.getElementById('amount').value) || 0;
    let interest = parseFloat(document.getElementById('interest').value) || 0;

    let interestAmount = amount * (interest / 100);
    let totalPayable = amount + interestAmount;

    document.getElementById('interest_amount').innerText = interestAmount.toFixed(2);
    document.getElementById('total_payable').innerText = totalPayable.toFixed(2);

    // ---------------- FUNDING ----------------
    let totalFunding = 0;

    document.querySelectorAll('.account_amount').forEach(input => {
        totalFunding += parseFloat(input.value) || 0;
    });

    let remaining = amount - totalFunding;

    document.getElementById('remaining_funding').innerText =
        remaining.toFixed(2);
}

// ---------------- ADD ROW ----------------
function addAccountRow() {

    let html = `
    <div class="row account-row" style="margin-top:10px;">

        <div>
            <select name="account_id[]" required>
                <option value="">Select Account</option>
                <?php foreach ($accounts as $account): ?>
                    <option value="<?= $account['id'] ?>">
                        <?= $account['account_name'] ?> (₱<?= number_format($account['balance'],2) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <input type="number"
                   name="account_amount[]"
                   class="account_amount"
                   placeholder="Amount"
                   required
                   oninput="calculateAll()">
        </div>

        <button type="button" class="remove-btn" onclick="removeRow(this)">X</button>

    </div>
    `;

    document.getElementById('account-wrapper')
        .insertAdjacentHTML('beforeend', html);
}

// ---------------- REMOVE ROW ----------------
function removeRow(btn) {
    btn.parentElement.remove();
    calculateAll();
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>