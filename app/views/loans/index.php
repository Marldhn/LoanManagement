<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

.container {
    padding: 20px;
}

h2 {
    margin-bottom: 15px;
}

/* BUTTONS */
button, a.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
    font-size: 14px;
}

.btn-primary {
    display: inline-block;
    padding: 8px 12px;
    background: #2d89ef;
    color: white;
    text-decoration: none;
    border-radius: 6px;
}
.btn-primary:hover { background: #1b5fbf; }

.btn-danger { background: #dc3545; color: white; }
.btn-danger:hover { background: #a71d2a; }

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

th {
    background: #f1f1f1;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
}

/* MODAL BACKDROP */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

/* MODAL BOX */
.modal-content {
    background: white;
    width: 420px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.modal-content h3 {
    margin-bottom: 15px;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin: 6px 0 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* SHOW MODAL */
.show {
    display: flex;
}

.ls-toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:15px;
}

.ls-search{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    align-items:center;
}

.ls-field input,
.ls-field select{
    padding:10px 12px;
    border:1px solid #ddd;
    border-radius:8px;
    outline:none;
    min-width:180px;
}

.ls-field input:focus,
.ls-field select:focus{
    border-color:#2d89ef;
}

.ls-btn{
    padding:10px 14px;
    background:#2d89ef;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.ls-btn:hover{
    background:#1b5fbf;
}

.ls-reset{
    padding:10px 12px;
    background:#f1f1f1;
    color:#333;
    border-radius:8px;
    text-decoration:none;
}

.ls-add{
    padding:10px 14px;
    background:#28a745;
    color:white;
    border-radius:8px;
    text-decoration:none;
}

.ls-add:hover{
    background:#1f7a33;
}


</style>

<div class="ls-toolbar">

    <h2>Loan List</h2>

    <form method="GET"
          action="/LoanManagement/public/index.php"
          class="ls-search">

        <input type="hidden" name="url" value="loan/index">

        <div class="ls-field">
            <input type="text"
                   name="search"
                   placeholder="🔍 Search borrower or account..."
                   value="<?= $_GET['search'] ?? '' ?>">
        </div>

        <div class="ls-field">
            <select name="status">
                <option value="">All Status</option>
                <option value="0" <?= (($_GET['status'] ?? '') === '0') ? 'selected' : '' ?>>Active</option>
                <option value="1" <?= (($_GET['status'] ?? '') === '1') ? 'selected' : '' ?>>Deleted</option>
            </select>
        </div>

        <div class="ls-field">
            <input type="date" name="date" value="<?= $_GET['date'] ?? '' ?>">
        </div>

        <button type="submit" class="ls-btn">
            Filter
        </button>

        <a href="/LoanManagement/public/index.php?url=loan/index" class="ls-reset">
            Reset
        </a>

    </form>

    <a class="ls-add"
       href="/LoanManagement/public/index.php?url=loan/create">
        + Add Loan
    </a>

</div>

<table>
    <tr>
        <th>Borrower</th>
        <th>Account</th>
        <th>Amount</th>
        <th>Interest</th>
        <th>Borrowed</th>
        <th>Due</th>
        <th>Penalty</th>
        <th>Overall Total</th>
        <th>Total Paid</th>
        <th>Remaining</th>
        <th>Action</th>
    </tr>

       <?php foreach ($loans as $loan): ?>

    <?php
    // BASE LOAN TOTAL (interest included already from DB)
    $total = $loan['total'] ?? 0;

    // PENALTY
    $penalty = $loan['total_penalty'] ?? 0;

    // TOTAL PAID
    $total_paid = $loan['total_paid'] ?? 0;

    // FINAL TOTAL DUE (THIS IS THE REAL AMOUNT CUSTOMER OWES)
    $overall_total = $total + $penalty;

    // REMAINING BALANCE
    $remaining = $overall_total - $total_paid;
?>

    <tr>
        <td><b><?= $loan['borrower_name'] ?></b></td>
        <td><b><?= $loan['account_names'] ?></b></td>

        <td><b></b>₱<?= number_format($loan['amount'], 2) ?></b></td>
        <td><b><?= $loan['interest'] ?>%</b></td>
        <td><b><?= $loan['borrowed_date'] ?></b></td>
        <td><b><?= $loan['due_date'] ?></b></td>

<td>₱<?= number_format($penalty, 2) ?></td>

<td>₱<?= number_format($overall_total, 2) ?></td>

<td>₱<?= number_format($total_paid, 2) ?></td>

<td>₱<?= number_format($remaining, 2) ?></td>

        <td>
            <button class="btn-primary"
                onclick="openPenaltyModal(<?= $loan['id'] ?>)">
                Penalty
            </button>

             <a class="btn btn-danger"
               href="/LoanManagement/public/index.php?url=loan/delete/<?= $loan['id'] ?>"
               onclick="return confirm('Delete this loan?')">
               Delete
            </a>
            <button onclick="openPaymentModal(<?= $loan['id'] ?>)">
    Pay
</button>

        </td>
    </tr>

    <?php endforeach; ?>
</table>

</div>



<!-- PENALTY MODAL -->
<div id="penaltyModal" class="modal">
    <div class="modal-content">

        <h3>Add Penalty</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/addPenalty">

            <input type="hidden" name="loan_id" id="penalty_loan_id">

            <label>Amount</label>
            <input type="number" name="amount" required>

            <label>Reason</label>
            <textarea name="reason"></textarea>

            <button class="btn-primary" type="submit">Save</button>
            <button type="button" onclick="closePenaltyModal()">Cancel</button>

        </form>

    </div>
</div>


<div id="paymentModal" class="modal">
    <div class="modal-content">
        <h3>Add Payment</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/addPayment">

            <input type="hidden" name="loan_id" id="payment_loan_id">

            <label>Amount</label>
            <input type="number" name="amount" required>

            <label>Notes</label>
            <textarea name="notes"></textarea>

            <button type="submit">Save</button>
            <button type="button" onclick="closePaymentModal()">Cancel</button>

        </form>
    </div>
</div>

<script>
function openPenaltyModal(id) {
    document.getElementById('penalty_loan_id').value = id;
    document.getElementById('penaltyModal').classList.add('show');
}

function closePenaltyModal() {
    document.getElementById('penaltyModal').classList.remove('show');
}

function openPaymentModal(id) {
    document.getElementById('payment_loan_id').value = id;
    document.getElementById('paymentModal').classList.add('show');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('show');
}
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>