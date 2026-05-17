<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial;
    background: #f5f6fa;
}

.container {
    padding: 20px;
}

/* CARD */
.card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* BUTTONS */
.btn {
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}

.btn-primary { background: #2d89ef; color: white; }
.btn-danger { background: #dc3545; color: white; }
.btn-success { background: #28a745; color: white; }

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

/* MODAL */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    width: 400px;
    border-radius: 10px;
}

.show { display: flex; }
</style>

<div class="container">

<a href="/LoanManagement/public/index.php?url=loan/index">⬅ Back</a>

<?php
$total = $loan['total'] ?? 0;
$penalty_total = array_sum(array_column($penalties, 'amount'));
$paid_total = array_sum(array_column($payments, 'amount'));

$overall = $total + $penalty_total;
$remaining = $overall - $paid_total;

if ($remaining <= 0) {
    $status = "PAID";
} elseif ($loan['due_date'] < date('Y-m-d')) {
    $status = "OVERDUE";
} else {
    $status = "ACTIVE";
}
?>

<!-- LOAN SUMMARY -->
<div class="card">
    <h3>Loan Details</h3>

    <p><b>Amount:</b> ₱<?= number_format($loan['amount'],2) ?></p>
    <p><b>Interest:</b> <?= $loan['interest'] ?>%</p>
    <p><b>Total:</b> ₱<?= number_format($overall,2) ?></p>
    <p><b>Paid:</b> ₱<?= number_format($paid_total,2) ?></p>
    <p><b>Remaining:</b> ₱<?= number_format($remaining,2) ?></p>
    <p><b>Status:</b> <?= $status ?></p>

    <button class="btn btn-primary" onclick="openPayment()">Add Payment</button>
    <button class="btn btn-danger" onclick="openPenalty()">Add Penalty</button>
</div>

<!-- PAYMENTS -->
<div class="card">
    <h3>Payments</h3>

    <table>
        <tr>
            <th>Amount</th>
            <th>Notes</th>
            <th>Date</th>
        </tr>

        <?php foreach ($payments as $p): ?>
        <tr>
            <td>₱<?= number_format($p['amount'],2) ?></td>
            <td><?= $p['notes'] ?></td>
            <td><?= $p['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- PENALTIES -->
<div class="card">
    <h3>Penalties</h3>

    <table>
        <tr>
            <th>Amount</th>
            <th>Reason</th>
        </tr>

        <?php foreach ($penalties as $p): ?>
        <tr>
            <td>₱<?= number_format($p['amount'],2) ?></td>
            <td><?= $p['reason'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</div>

<!-- ===================== -->
<!-- PAYMENT MODAL -->
<!-- ===================== -->
<div id="paymentModal" class="modal">
    <div class="modal-content">

        <h3>Add Payment</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/addPayment">

            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">

            <label>Amount</label>
            <input type="number" name="amount" required>

            <!-- ✅ ACCOUNT SELECT (FIXED) -->
            <label>Pay From Account</label>
            <select name="account_id" required>
                <option value="">Select Account</option>

                <?php foreach ($accounts as $account): ?>
                    <option value="<?= $account['id'] ?>">
    <?= $account['account_name'] ?> 
    — Balance: ₱<?= number_format($account['balance'], 2) ?>
</option>
                <?php endforeach; ?>
            </select>

            <label>Notes</label>
            <textarea name="notes"></textarea>

            <button class="btn btn-success" type="submit">Save</button>
            <button type="button" onclick="closePayment()">Cancel</button>

        </form>

    </div>
</div>

<!-- ===================== -->
<!-- PENALTY MODAL -->
<!-- ===================== -->
<div id="penaltyModal" class="modal">
    <div class="modal-content">

        <h3>Add Penalty</h3>

        <form method="POST" action="/LoanManagement/public/index.php?url=loan/addPenalty">

            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">

            <label>Amount</label>
            <input type="number" name="amount" required>

            <label>Reason</label>
            <textarea name="reason"></textarea>

            <button class="btn btn-danger" type="submit">Save</button>
            <button type="button" onclick="closePenalty()">Cancel</button>

        </form>

    </div>
</div>

<script>
function openPayment() {
    document.getElementById('paymentModal').classList.add('show');
}

function closePayment() {
    document.getElementById('paymentModal').classList.remove('show');
}

function openPenalty() {
    document.getElementById('penaltyModal').classList.add('show');
}

function closePenalty() {
    document.getElementById('penaltyModal').classList.remove('show');
}
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>