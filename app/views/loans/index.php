<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<h2>Loan List</h2>

<a href="/LoanManagement/public/index.php?url=loan/create">
    Add Loan
</a>

<br><br>

<table border="1" cellpadding="10">

    <tr>
               <th>Loan ID</th>
        <th>Borrower</th>
        <th>Account</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Date Borrowed</th>
<th>Due Date</th>
<th>Penalty</th>
        <th>Total Due</th>
        <th>Overall Total</th>
        <th>Action</th>
    </tr>

    <?php if (!empty($loans)): ?>

        <?php foreach ($loans as $loan): ?>

        <tr>

            <td><?= $loan['id'] ?></td>
            <td><?= $loan['borrower_name'] ?></td>

            <td><?= $loan['account_names'] ?></td>

            <td>₱<?= number_format($loan['amount'], 2) ?></td>
<td>₱<?= $loan['interest'] ?>%</td>

            <td><?= $loan['borrowed_date'] ?></td>
<td><?= $loan['due_date'] ?></td>
<td>₱<?= number_format($loan['total_penalty'], 2) ?></td>

            <td><?= $loan['interest'] ?>%</td>

            <td>
    ₱<?= number_format($loan['total'] + $loan['total_penalty'], 2) ?>
</td>

            <td>
                |
<a href="#"
   onclick="openPenaltyModal(
        <?= $loan['id'] ?>,
        <?= $loan['borrower_id'] ?>
   )">
   Penalty
</a>
                <a href="/LoanManagement/public/index.php?url=loan/delete/<?= $loan['id'] ?>"
   onclick="return confirm('Delete loan?')">
   Delete
</a>
            </td>

        </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="5">No loans found</td>
        </tr>

    <?php endif; ?>

</table>



<!-- CREATE LOAN MODAL -->
<div id="loanCreateModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:500px; margin:8% auto; padding:20px;">

        <h3>Create Loan</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/store">

            <!-- BORROWER -->
            <label>Borrower</label><br>
            <select name="borrower_id" required>
                <option value="">Select Borrower</option>

                <?php foreach ($borrowers as $b): ?>
                    <option value="<?= $b['id'] ?>">
                        <?= $b['fullname'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br><br>

            <!-- ACCOUNT -->
            <label>Account</label><br>
            <select name="account_id" required>
                <option value="">Select Account</option>

                <?php foreach ($accounts as $a): ?>
                    <option value="<?= $a['id'] ?>">
                        <?= $a['account_name'] ?> - ₱<?= $a['balance'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br><br>

            <!-- AMOUNT -->
            <input type="number" name="amount" placeholder="Amount" required><br><br>

            <!-- INTEREST -->
            <input type="number" name="interest" placeholder="Interest %" required><br><br>

            <button type="submit">Save Loan</button>
            <button type="button" onclick="closeLoanCreateModal()">Cancel</button>

        </form>

    </div>
</div>




<div id="loanEditModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:500px; margin:8% auto; padding:20px;">

        <h3>Edit Loan</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/update">

            <input type="hidden" name="id" id="loan_id">

            <input type="number" name="amount" id="loan_amount"><br><br>
            <input type="number" name="interest" id="loan_interest"><br><br>

            <button type="submit">Update</button>
            <button type="button" onclick="closeLoanEditModal()">Cancel</button>

        </form>

    </div>
</div>




<!-- PENALTY MODAL -->
<div id="penaltyModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
background:rgba(0,0,0,0.5);">

    <div style="background:white; width:400px; margin:10% auto; padding:20px;">

        <h3>Add Penalty</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/addPenalty">

            <input type="hidden" name="loan_id" id="penalty_loan_id">
            <input type="hidden" name="borrower_id" id="penalty_borrower_id">

            <label>Penalty Amount</label><br>
            <input type="number" name="amount" required>

            <br><br>

            <label>Reason</label><br>
            <textarea name="reason" required></textarea>

            <br><br>

            <button type="submit">Save Penalty</button>
            <button type="button" onclick="closePenaltyModal()">Cancel</button>

        </form>

    </div>
</div>



<script>

function openPenaltyModal(loan_id, borrower_id) {

    document.getElementById('penalty_loan_id').value = loan_id;
    document.getElementById('penalty_borrower_id').value = borrower_id;

    document.getElementById('penaltyModal').style.display = 'block';
}

function closePenaltyModal() {
    document.getElementById('penaltyModal').style.display = 'none';
}

function openLoanCreateModal() {
    document.getElementById('loanCreateModal').style.display = 'block';
}

function closeLoanCreateModal() {
    document.getElementById('loanCreateModal').style.display = 'none';
}

// EDIT
function openLoanEditModal(id, amount, interest) {
    document.getElementById('loan_id').value = id;
    document.getElementById('loan_amount').value = amount;
    document.getElementById('loan_interest').value = interest;

    document.getElementById('loanEditModal').style.display = 'block';
}

function closeLoanEditModal() {
    document.getElementById('loanEditModal').style.display = 'none';
}

</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>