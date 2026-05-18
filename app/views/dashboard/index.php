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

/* DASHBOARD CHART SECTION */
.chart-container{
    display:flex;
    gap:20px;
    margin-top:30px;
}

/* LEFT CHART (Profit vs Expenses) */
.chart-box{
    flex:1;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

/* RIGHT SIDE (for Loan Released vs Paid later) */
.chart-box-right{
    flex:1;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

canvas{
    max-height:280px; /* 👈 THIS MAKES CHART SMALLER */
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

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Account Balance</h3>
            <h1>₱<?= number_format($totalAccountBalance, 2) ?></h1>
        </div>

        <div class="card">
            <h3>Upcoming Profit</h3>
            <h1>₱<?= number_format($upcomingProfit, 2) ?></h1>
        </div>

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
            <h1 style="color:red;">
                ₱<?= number_format($totalExpenses, 2) ?>
            </h1>
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

    <!-- CHARTS SECTION -->
    <div class="chart-container">

        <!-- LEFT: PROFIT VS EXPENSES -->
        <div class="chart-box">
            <h3>Monthly Profit vs Expenses</h3>
            <canvas id="financeChart"></canvas>
        </div>

        <!-- RIGHT: PLACEHOLDER -->
       <div class="chart-box-right">
    <h3>Loan Released vs Paid</h3>
    <canvas id="loanChart"></canvas>
</div>

    </div>

    <!-- TABLE -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const profitData = <?= json_encode($profitMonthly) ?>;
const expenseData = <?= json_encode($expenseMonthly) ?>;

// labels
const labels = profitData.map(item => item.month);

// values
const profits = profitData.map(item => item.total);
const expenses = expenseData.map(item => item.total);

new Chart(document.getElementById('financeChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Profit',
                data: profits,
                backgroundColor: 'green'
            },
            {
                label: 'Expenses',
                data: expenses,
                backgroundColor: 'red'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

new Chart(document.getElementById('loanChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($loanLabels) ?>,
        datasets: [
            {
                label: 'Loan Released',
                data: <?= json_encode($loanReleased) ?>,
                backgroundColor: 'blue'
            },
            {
                label: 'Paid',
                data: <?= json_encode($loanPaid) ?>,
                backgroundColor: 'orange'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php include __DIR__ . "/../layouts/footer.php"; ?>