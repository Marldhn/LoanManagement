<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Create Loan</h2>

<form method="POST" action="/LoanManagement/public/index.php?url=loan/store">

    <!-- BORROWER -->
    <label>Borrower</label><br>

    <select name="borrower_id" required>

        <option value="">Select Borrower</option>

        <?php foreach ($borrowers as $borrower): ?>

            <option value="<?= $borrower['id'] ?>">

                <?= $borrower['fullname'] ?>

            </option>

        <?php endforeach; ?>

    </select>

    <label>Guarantor (Optional)</label><br>

<select name="guarantor_id">

    <option value="">-- No Guarantor --</option>

    <?php foreach ($guarantors as $g): ?>

        <option value="<?= $g['id'] ?>">
            <?= $g['fullname'] ?>
        </option>

    <?php endforeach; ?>

</select>

<br><br>

    <br><br>

    <!-- LOAN AMOUNT -->
    <label>Loan Amount</label><br>

    <input type="number" name="amount" required>

    <br><br>

    <!-- INTEREST -->
    <label>Interest (%)</label><br>

    <input type="number" name="interest" required>

    <br><br>

    <!-- FUNDING ACCOUNTS -->
    <label>Funding Accounts</label>

    <div id="account-wrapper">

        <div class="account-row">

            <select name="account_id[]" required>

                <option value="">Select Account</option>

                <?php foreach ($accounts as $account): ?>

                    <option value="<?= $account['id'] ?>">

                        <?= $account['account_name'] ?>

                        (Balance: ₱<?= number_format($account['balance'], 2) ?>)

                    </option>

                <?php endforeach; ?>

            </select>

            <input 
                type="number" 
                name="account_amount[]" 
                placeholder="Amount"
                required
            >

        </div>

    </div>

    <br>

    <button type="button" onclick="addAccountRow()">
        Add Account
    </button>

    <br><br>

    <button type="submit">
        Save Loan
    </button>

</form>

<script>

function addAccountRow() {

    let html = `

        <div class="account-row" style="margin-top:10px;">

            <select name="account_id[]" required>

                <option value="">Select Account</option>

                <?php foreach ($accounts as $account): ?>

                    <option value="<?= $account['id'] ?>">

                        <?= $account['account_name'] ?>

                        (Balance: ₱<?= number_format($account['balance'], 2) ?>)

                    </option>

                <?php endforeach; ?>

            </select>

            <input 
                type="number" 
                name="account_amount[]" 
                placeholder="Amount"
                required
            >

        </div>
    `;

    document.getElementById('account-wrapper')
        .insertAdjacentHTML('beforeend', html);
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>