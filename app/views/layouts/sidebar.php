<style>
/* =========================
LOAN SYSTEM SIDEBAR
========================= */

.ls-wrapper {
    display: flex;
}

/* Sidebar */
.ls-sidebar {
    width: 220px;
    height: 100vh;
    background: #2c3e50;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
}

/* Title */
.ls-sidebar h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Links */
.ls-sidebar a {
    display: block;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    transition: 0.2s;
}

.ls-sidebar a:hover {
    background: #34495e;
}

/* Content */
.ls-content {
    margin-left: 220px;
    padding: 20px;
    width: 100%;
}

/* =========================
USER DROPDOWN AREA
========================= */

.ls-userbox {
    margin-top: auto;
    border-top: 1px solid #34495e;
    padding: 10px 15px;
}

/* Top row (name + dropdown button) */
.ls-user-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.ls-user-name {
    font-weight: bold;
}

/* Dropdown button */
.ls-dropdown-btn {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

/* Dropdown menu */
.ls-dropdown {
    display: none;
    background: #22313f;
    margin-top: 8px;
    border-radius: 5px;
    overflow: hidden;
}

.ls-dropdown a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    font-size: 14px;
}

.ls-dropdown a:hover {
    background: #1abc9c;
}

.ls-role {
    font-size: 12px;
    color: #bdc3c7;
    margin-top: 5px;
}

/* Divider look */
.ls-divider {
    border-top: 1px solid #34495e;
    margin-top: 10px;
}
</style>

<div class="ls-wrapper">

    <div class="ls-sidebar">

        <h2>Loan System</h2>

        <a href="/LoanManagement/public/index.php?url=dashboard/index">Dashboard</a>
        <a href="/LoanManagement/public/index.php?url=account/index">Accounts</a>
        <a href="/LoanManagement/public/index.php?url=borrower/index">Borrowers</a>
        <a href="/LoanManagement/public/index.php?url=loan/index">Loans</a>
        <a href="/LoanManagement/public/index.php?url=guarantor/index">Guarantors</a>

        <!-- USER BOX -->
        <div class="ls-userbox">

            <div class="ls-user-top" onclick="toggleUserDropdown()">

                <div class="ls-user-name">
                    <?= $_SESSION['user']['name'] ?? 'User' ?>
                </div>

                <button class="ls-dropdown-btn">▾</button>

            </div>

            <div class="ls-role">
                <?= $_SESSION['user']['role'] ?? 'Member' ?>
            </div>

            <div class="ls-dropdown" id="userDropdown">

                <a href="/LoanManagement/public/index.php?url=profile/index">
                    Profile
                </a>

                <a href="/LoanManagement/public/index.php?url=auth/logout">
                    Logout
                </a>

            </div>

            <div class="ls-divider"></div>

        </div>

    </div>

    <div class="ls-content">

    <script>
function toggleUserDropdown() {
    const menu = document.getElementById("userDropdown");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}
</script>