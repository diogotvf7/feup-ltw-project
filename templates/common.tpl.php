<?php 
    require_once(__DIR__ . '/../utils/util_funcs.php');
    include_once('../utils/session.php');
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
        <h1 id="logo">
            <a href="../pages/index.php">
            <i class="fa fa-exchange"></i>UP Tickets
            </a>
        </h1>
        </header>
<?php } ?>

<?php function drawFooter() { ?>
    </body>
    </html>
<?php } ?>

<?php function drawSideBar($user) { 
    $userType = getUserType($user);
    ?>
    <aside id="sidebar">
     <?php 
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
    <ul class="admin">
        <li><a href="../pages/users.php">Admin</a></li>
        <li><a href="../pages/departaments.php">Agents</a></li>
        <li><a href="../pages/system.php">Clients</a></li>
    </ul>
<?php } ?>

<?php function drawAgentSideBar() { ?>
    <ul class="agent">
        <li><a href="../pages/tickets_queues.php"> Tickets queues</a></li>
    </ul>
<?php } ?>

<?php function drawClientSideBar() { ?>
    <ul class="client">
        <li><a href="../pages/account_settings.php">My account</a></li>
        <li><a href="../pages/display_tickets?filter=user">My tickets</a></li>
        <li><a href="../pages/faq.php">FAQ</a></li>
    </ul>
<?php drawLogout();}
?>

<?php function drawLogout() { ?>
    <ul class="logout">
        <li><a href="../actions/action_logout.php">Logout </a></li>
    </ul>
<?php } ?>