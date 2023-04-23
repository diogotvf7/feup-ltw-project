<?php 
    require_once(__DIR__ . '/../utils/util_funcs.php');
?>
<?php function drawHeader($scripts) { ?>
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
        <h1 id="logo">
            <a href="../pages/index.php">
            <i class="fa fa-exchange"></i>UP Tickets
            </a>
        </h1>
        <?php
        include_once('../includes/session.php');
         if (isset($_SESSION['userid'])){ ?>
        <h1 id="logout">
            <form action="../actions/action_logout.php">
            <a href="../pages/login.php">
            <i class="fa fa-sign-out"></i>Logout
            </a>
            </form>
        </h1>
        <?php } ?>
        </header>
<?php } ?>

<?php function drawFooter() { ?>
    </body>
    </html>
<?php } ?>

<?php function drawSideBar($user) { 
    $userType = getUserType($user);

    ?> <aside id="sidebar"> <?php 
    switch($userType) {
        case 'Admin':
            drawAdminSideBar($user);
        case 'Agent':
            drawAgentSideBar($user);
        case 'Client':
            drawClientSideBar($user);
    }
    ?> </aside> <?php 

} ?>

<?php function drawAdminSideBar() { ?>
    <ul>
        <li><a href="../pages/users.php">Admin</a></li>
        <li><a href="../pages/departaments.php">Agents</a></li>
        <li><a href="../pages/system.php">Clients</a></li>
    </ul>
<?php } ?>

<?php function drawAgentSideBar() { ?>
    <ul>
        <li><a href="../pages/display_tickets"> Tickets queues</a></li>
    </ul>
<?php } ?>

<?php function drawClientSideBar() { ?>
    <ul>
        <li><a href="../pages/account_settings.php">My account</a></li>
        <li><a href="../pages/display_tickets?filter=user">My tickets</a></li>
        <li><a href="../pages/faq.php">FAQ</a></li>
    </ul>
<?php } ?>