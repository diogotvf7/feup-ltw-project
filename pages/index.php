<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../utils/util_funcs.php');

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

<?=getUserType($db, 1)?><br>
<?=getUserType($db, 2)?><br>
<?=getUserType($db, 3)?><br>
<?=getUserType($db, 4)?><br>
<?=getUserType($db, 5)?><br>
<?=getUserType($db, 6)?><br>
<?=getUserType($db, 7)?><br>
<?=getUserType($db, 8)?><br>
<?=getUserType($db, 9)?><br>
<?=getUserType($db, 10)?><br>
<?=getUserType($db, 11)?><br>
<?=getUserType($db, 12)?><br>
<?=getUserType($db, 13)?><br>

<?php
  drawFooter();
?>
