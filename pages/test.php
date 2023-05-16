<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/department.class.php');

    echo '<br><br><br><br>';

    $ret = array();
    $ret['func'] = 'display_tickets';

    $tickets = Ticket::getTickets(
        $db,
        '',
        array(),
        array(),
        '',
        '',
        null,
        null
    );
    var_dump($tickets);
?>

<p>
    Coiso com botao para mostrar tickets
    <button onclick="display_tickets()">Display tickets</button>
</p>