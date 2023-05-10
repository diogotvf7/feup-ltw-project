<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');

    // var_dump(Ticket::getTickets($db, 'Open', array(), array(), '3', ''));
    $allTickets = array_column(Ticket::getAllTickets($db), 'TicketID');
    $filteredTickets = array_column(Ticket::filterTicketsByStatus($db, 'Open'), 'TicketID');
    
    var_dump($allTickets);
    echo '<br><br><br><br>';
    var_dump($filteredTickets);
    echo '<br><br><br><br>';
    var_dump(array_intersect($allTickets, $filteredTickets));
    

    echo '<br><br><br><br>';
    $arr1 = array('a', 'b', 'c', 'e', 'f', 'g', 'h');
    $arr2 = array('a', 'b', 'c', 'g', 'h');
    $arr1 = array_intersect($arr1, $arr2);
    var_dump($arr1);
?>