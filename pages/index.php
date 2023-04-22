<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');

  $db = getDatabaseConnection();

  /*
  if (!$db.isConnected()) {
  echo "Error: Unable to connect to database.";}
    */

  drawHeader($session);
  drawHeader(["script"]);
?>
<a href="../pages/login.php">LOGIN</a>
<a href="../pages/display_tickets.php">DISPLAY TICKETS</a>
<?php
  drawFooter();
?>
