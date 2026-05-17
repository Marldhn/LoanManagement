<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
}

.container {
    padding: 20px;
}

/* HEADER CARD */
.ls-header {
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.ls-header h2 {
    margin: 0;
}

/* FILTER BAR */
.ls-toolbar {
    background: white;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 15px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.ls-toolbar input,
.ls-toolbar select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}

/* BUTTONS */
.btn {
    padding: 10px 14px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #2d89ef;
    color: white;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

th {
    background: #f1f3f6;
    text-align: left;
    padding: 12px;
}

td {
    padding: 12px;
    border-top: 1px solid #eee;
}

/* STATUS BADGE */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.badge-active { background: #e7f5ff; color: #1971c2; }
.badge-paid { background: #e6fcf5; color: #099268; }
.badge-overdue { background: #fff5f5; color: #e03131; }
</style>

<div class="container">

<!-- HEADER -->
<div class="ls-header">
    <h2>Active Loans</h2>
    <a class="btn btn-success" href="/LoanManagement/public/index.php?url=loan/create">
        + Create Loan
    </a>
</div>

<!-- FILTER -->
<form class="ls-toolbar" method="GET" action="/LoanManagement/public/index.php">

    <input type="hidden" name="url" value="loan/index">

    <input type="text" name="search" placeholder="Search borrower...">

    <select name="status">
        <option value="">Active Only</option>
        <option value="paid">Paid</option>
        <option value="overdue">Overdue</option>
    </select>

    <input type="date" name="date">

    <button class="btn btn-primary">Filter</button>
</form>

<!-- TABLE -->
<table>
<tr>
    <th>Borrower</th>
    <th>Loan</th>
    <th>Due Date</th>
    <th>Remaining</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php foreach ($loans as $loan): ?>

<?php
$total = $loan['total'] ?? 0;
$penalty = $loan['total_penalty'] ?? 0;
$paid = $loan['total_paid'] ?? 0;

$overall = $total + $penalty;
$remaining = $overall - $paid;

if ($remaining <= 0) {
    $status = "PAID";
    $badge = "badge-paid";
} elseif ($loan['due_date'] < date('Y-m-d')) {
    $status = "OVERDUE";
    $badge = "badge-overdue";
} else {
    $status = "ACTIVE";
    $badge = "badge-active";
}
?>

<tr>
    <td><b><?= $loan['borrower_name'] ?></b></td>
    <td>₱<?= number_format($loan['amount'],2) ?></td>
    <td><?= $loan['due_date'] ?></td>
    <td>₱<?= number_format($remaining,2) ?></td>

    <td>
        <span class="badge <?= $badge ?>">
            <?= $status ?>
        </span>
    </td>

    <td>
        <a class="btn btn-primary"
           href="/LoanManagement/public/index.php?url=loan/details/<?= $loan['id'] ?>">
            View
        </a>
    </td>
</tr>

<?php endforeach; ?>

</table>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>