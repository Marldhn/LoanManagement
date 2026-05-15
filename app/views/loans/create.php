<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
.container {
    max-width: 700px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
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
}

.row > div {
    flex: 1;
}

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
            <input type="number" name="days" placeholder="e.g. 15" required>
        </div>

    </div>

    <!-- AMOUNT -->
    <label>Loan Amount</label>
    <input type="number" name="amount" required>

    <!-- INTEREST -->
    <label>Interest (%)</label>
    <input type="number" name="interest" required>

    <!-- FUNDING ACCOUNTS -->
    <label>Funding Accounts</label>

    <div id="account-wrapper">

        <div class="row">

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
                <input type="number" name="account_amount[]" placeholder="Amount" required>
            </div>

        </div>

    </div>

    <br>

    <button type="button" onclick="addAccountRow()">+ Add Account</button>

    <br><br>

    <button type="submit">Save Loan</button>

</form>

</div>

<script>

function addAccountRow() {

    let html = `
    <div class="row" style="margin-top:10px;">
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
            <input type="number" name="account_amount[]" placeholder="Amount" required>
        </div>
    </div>
    `;

    document.getElementById('account-wrapper')
        .insertAdjacentHTML('beforeend', html);
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>