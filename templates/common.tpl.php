<?php 
    require_once(__DIR__ . '/../utils/util_funcs.php');
?>
<?php function drawHeader($scripts = []) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <title>UP Tickets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <?php foreach ($scripts as $script) { 
          echo '<script src="../javascript/', $script, '.js" defer></script>';
        } ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
        <h1>
            <a href="../pages/index.php">
                UP Tickets
            </a>
        </h1>
        </header>
<?php } ?>

<?php function drawFooter() { ?>
    </body>
    </html>
<?php } ?>

<?php function drawNavBar($user) { 
    $userType = getUserType($user);

    ?> <nav id="nav-bar"> <?php 
    switch($userType) {
        case 'Admin':
            drawAdminNavBar($user);
        case 'Agent':
            drawAgentNavBar($user);
        case 'Client':
            drawClientNavBar($user);
    }
    ?> </nav> <?php 

} ?>

<?php function drawAdminNavBar() { ?>
    <ul>
        <a href="../pages/users.php">
            <li>
                <i class="fa fa-wrench" aria-hidden="true"></i>
                <div class="sidebar-text">
                    Users
                </div>
            </li>
        </a>
        <a href="../pages/departaments.php">
            <li>
                <i class="fa fa-briefcase" aria-hidden="true"></i>
                <div class="sidebar-text">
                    Agents
                </div>
            </li>
        </a>
        <a href="../pages/system.php">
            <li>
                <i class="fa fa-users" aria-hidden="true"></i>
                <div class="sidebar-text">
                    Clients
                </div>
            </li>
        </a>
    </ul>
<?php } ?>

<?php function drawAgentNavBar() { ?>
    <ul>
        <a href="../pages/display_tickets">
            <li>
                <i class="fa fa-ticket" aria-hidden="true"></i>
                <div class="sidebar-text">
                    Tickets queues
                </div>
            </li>
        </a>
    </ul>
<?php } ?>

<?php function drawClientNavBar() { ?>
    <ul>
        <a href="../pages/account_settings.php">
            <li>
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <div class="sidebar-text">
                    My account
                </div>
            </li>
        </a>
        <a href="../pages/display_tickets?filter=user">
            <li>
                <i class="fa fa-archive" aria-hidden="true"></i>
                <div class="sidebar-text">
                    My tickets
                </div>
            </li>
        </a>
        <a href="../pages/faq.php">
            <li>
                <i class="fa fa-question-circle" aria-hidden="true"></i>
                <div class="sidebar-text">
                    FAQ
                </div>
            </li>
        </a>
    </ul>
<?php } ?>