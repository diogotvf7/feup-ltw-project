<?php 
    require_once(__DIR__ . '/../utils/util_funcs.php');
    include_once('../utils/session.php');
    include_once('../database/connection.db.php');
?>

<?php function drawHeader($scripts = [], $cssFiles = []) { ?>
    <!DOCTYPE html>
        <html lang="en-US">
            <head>
                <title>UP Tickets</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <?php foreach ($cssFiles as $css) { 
                    echo '<link rel="stylesheet" href="../css/' . $css . '.css">';
                } ?>
                <?php foreach ($scripts as $script) { 
                    echo '<script src="../javascript/', $script, '.js" defer></script>';
                } ?>
                <script src="https://kit.fontawesome.com/7fdc1f36c9.js" crossorigin="anonymous"></script>
            </head>
            <body>
<?php } ?>

<?php function drawFooter() { ?>
        </body>
    </html>
<?php } ?>

<?php function drawNavBar($userType) { ?>
    <nav class="navbar"> 
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="../pages/index.php" class="nav-link">
                    <img src="../docs/simple-logo.png" width="100%" />
                    <span class="logo-text">UP Tickets</span>
                </a>
            </li>
            <?php switch($userType) {
                case 'Admin':
                    drawAdminNavBar();
                case 'Agent':
                    drawAgentNavBar();
                case 'Client':
                    drawClientNavBar();
            } ?>
            <li class="nav-item">
                <a href="../actions/action_logout.php" class="nav-link">
                    <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                    <span class="link-text">Logout</span>
                </a>
            </li> 
        </ul>
    </nav> 

<?php } ?>

<?php function drawAdminNavBar() { ?>
    <li class="nav-item">
            <a href="../pages/admins.php" class="nav-link">
            <i class="fa-solid fa-gear fa-lg"></i>
            <span class="link-text">Admin</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="../pages/agents.php" class="nav-link">
            <i class="fa-solid fa-briefcase fa-lg"></i>
            <span class="link-text">Agents</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="../pages/users.php" class="nav-link">
            <i class="fa-solid fa-users fa-lg"></i>
            <span class="link-text">Clients</span>
        </a>
    </li>
<?php } ?>

<?php function drawAgentNavBar() { ?>
    <li class="nav-item">
        <a href="../pages/display_tickets.php" class="nav-link">
            <i class="fa-solid fa-list-check fa-lg"></i>
            <span class="link-text">Tickets queues</span>
        </a>
    </li>
<?php } ?>

<?php function drawClientNavBar() { ?>
    <li class="nav-item">
        <a href="../pages/account_settings.php" class="nav-link">
            <i class="fa-solid fa-user fa-lg"></i>
            <span class="link-text">My account</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="../pages/my_tickets.php" class="nav-link">
            <i class="fa-solid fa-ticket fa-lg"></i>
            <span class="link-text">My tickets</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="../pages/faq.php" class="nav-link">
            <i class="fa-solid fa-circle-question fa-lg"></i>
            <span class="link-text">FAQ</span>
        </a>
    </li>
<?php } ?>