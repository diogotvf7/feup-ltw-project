<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/ticket.tpl.php');
  require_once (__DIR__ . '/../database/admin.class.php');
  require_once (__DIR__ . '/../database/agent.class.php');
  require_once (__DIR__ . '/../database/client.class.php');
  require_once (__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/tag.class.php');
    require_once(__DIR__ . '/../vendor/autoload.php');
    use Carbon\Carbon;


    drawHeader(['ticket_colors']);
    $db = getDatabaseConnection();
    $tickets = Ticket::getAgentTickets($db, $_SESSION['IDUSER']);
    //$tickets = Ticket::getAllTickets($db);
    if ($tickets == null) {echo 'No tickets found!' . '<br>';}
    else {drawTicketsList($db,$tickets);}
    drawFooter();
?>

<aside id="sidebar">
<ul class="tickets_queues">
        <li><a href="../pages/tickets_queues.php">Assigned to me</a></li>
</ul>
</aside>
