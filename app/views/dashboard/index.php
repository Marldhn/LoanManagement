<?php include __DIR__ . "/../layouts/sidebar.php"; ?>

<style>
body{
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

.dashboard-container{
    padding:20px;
}

.dashboard-title{
    margin-bottom:20px;
}

.cards{
    display:grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.card h3{
    margin:0;
    font-size:16px;
    color:#777;
}

.card h1{
    margin-top:10px;
    font-size:32px;
    color:#2d89ef;
}

.table-box{
    margin-top:30px;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #ddd;
    padding:12px;
}

table th{
    background:#f1f1f1;
}
</style>

<div class="dashboard-container">

    <h2 class="dashboard-title">Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>Total Account Balance</h3>
            <h1>₱<?= number_format($totalAccountBalance, 2) ?></h1>
        </div>

        <div class="card">
        <h3>Upcoming Profit</h3>
<h1>₱<?= number_format($upcomingProfit, 2) ?></h1>
        </div>

        <!-- ✅ NEW CARD -->
        <div class="card">
            <h3>Active Loans</h3>
            <h1><?= $totalActiveLoans ?></h1>
        </div>


        <div class="card">
            <h3>Total Borrowers</h3>
            <h1><?= $totalBorrowers ?></h1>
        </div>

        <div class="card">
            <h3>Total Accounts</h3>
            <h1><?= $totalAccounts ?></h1>
        </div>

        <div class="card">
    <h3>Total Expenses</h3>
    <h2 style="color:red;">
        ₱<?= number_format($totalExpenses, 2) ?>
    </h2>
</div>

        <div class="card">
            <h3>Total Loans</h3>
            <h1><?= $totalLoans ?></h1>
        </div>

        <div class="card">
            <h3>Total Loan Amount</h3>
            <h1>₱<?= number_format($totalAmount, 2) ?></h1>
        </div>

        

    </div>

    <div class="table-box">

        <h3>Recent Loans</h3>

        <table>

            <tr>
                <th>Borrower</th>
                <th>Amount</th>
                <th>Interest</th>
                <th>Due Date</th>
            </tr>

            <?php foreach($recentLoans as $loan): ?>

            <tr>
                <td><?= $loan['borrower_name'] ?></td>
                <td>₱<?= number_format($loan['amount'],2) ?></td>
                <td><?= $loan['interest'] ?>%</td>
                <td><?= $loan['due_date'] ?></td>
            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

<?php include __DIR__ . "/../layouts/footer.php"; ?>