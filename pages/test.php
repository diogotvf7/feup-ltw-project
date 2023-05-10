<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');


    $departments = '2,3';
    echo 'departments: '; var_dump($departments);
    echo '<br><br><br><br>';
    echo 'filterByDepartments: '; var_dump(Ticket::filterTicketsByDeparments($db, $departments));
    echo '<br><br><br><br>';
    echo 'intersection: ';
    var_dump(array_intersect(Ticket::getAllTickets($db), array_values(Ticket::filterTicketsByDeparments($db, $departments))));



?>