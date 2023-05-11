<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/department.class.php');

    echo '<br><br><br><br>';
    $ticketData = Ticket::getTicketData($db, $id);
    var_dump($ticketData['TicketID']);
?>