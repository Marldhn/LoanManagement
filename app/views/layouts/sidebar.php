<style>
body {
    margin: 0;
    font-family: Arial;
}

.wrapper {
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #2c3e50;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
}

.sidebar a:hover {
    background: #34495e;
}

/* Content */
.content {
    margin-left: 220px;
    padding: 20px;
    width: 100%;
}
</style>

<div class="wrapper">

    <div class="sidebar">
        <h2>Loan System</h2>

        <a href="/LoanManagement/public/index.php?url=account/index">Accounts</a>
        <a href="/LoanManagement/public/index.php?url=borrower/index">Borrowers</a>
        <a href="/LoanManagement/public/index.php?url=loan/index">Loans</a>
        <a href="/LoanManagement/public/index.php?url=account/create">Add Account</a>
        <a href="/LoanManagement/public/index.php?url=loan/create">Create Loan</a>
        <a href="/LoanManagement/public/index.php?url=borrower/create">Add Borrower</a>
        <a href="/LoanManagement/public/index.php?url=guarantor/index">Guarantors</a>
        <a href="/LoanManagement/public/index.php?url=guarantor/create">Add Guarantor</a>
    </div>

    

    <div class="content">