<?php 
    require_once(__DIR__ . '/../database/tag.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/client.class.php');
    require_once(__DIR__ . '/../database/agent.class.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../vendor/autoload.php');
    use Carbon\Carbon;
?>

<?php function drawTicketPreview($db, $id) { 
    $ticket = Ticket::getTicketData($db, $id);
    $tags = Ticket::getTicketTags($db, $ticket->id);
    $author = Client::getClient($db, $ticket->clientId);
    // $department = Department::getDepartment($db, $ticket->departmentId);
?>
    <a class="ticket" href="ticket_page.php?id=<?=$id;?>">
        <h3 class="title">
            <?=$ticket->title?>
        </h3>
        <p class="time">
            <?=Carbon::create($ticket->date)->diffForHumans()?>
        </p>
        <p class="description">
            <?=$ticket->description?>
        </p>
        <div class="tags">
        <p class="status">
            <?=$ticket->status?>
        </p>
        <?php foreach ($tags as $tag)
            echo '<p class="tag">' . $tag['Name'] . '</p>';
        ?>
        </div>
        <p class="author">
            <?='@' . $author->username?>  
        </p>
    </a>
<?php } ?>

<?php function drawTicketsList($db, $tickets) { ?>
    <main>
        <ul id="tickets-list">
            <?php foreach ($tickets as $ticket) {
                drawTicketPreview($db, $ticket["TicketID"]);
            } ?>
        </ul>
    </main>
<?php } ?>

<?php function drawTicket($db, $ticketId) {
    $ticket = Ticket::getTicketData($db, $ticketId);
    $tags = Ticket::getTicketTags($db, $ticketId);
    $documents = Ticket::getDocuments($db, $ticketId);
    $author = Client::getClient($db, $ticket->clientId);
    $agent = Agent::getAgent($db, $ticket->agentId);
    $department = Department::getDepartment($db, $ticket->departmentId);
    ?>

    <div id="ticket">
        <h1> 
            <?=$ticket->title;?> 
        </h1>
        <p id="description"> 
            <?=$ticket->description;?>
        </p>
        <?php
            foreach ($documents as $document) {
                var_dump($document);
                echo  '<img href="' . __DIR__ . '/../' . $document['Path'] . '><br>';
                echo $document['Path'] . '<br><br>';
            }   
        ?>
        <p> 
            <?=$ticket->status;?>
            <?php foreach ($tags as $tag)
                echo '<p class="tag">' . $tag['Name'] . '</p>';
            ?>
            Department: <?=$department->name;?>
            By: <?='@' . $author->username;?>
            Currently assigned to: <?='@' . $agent->username;?>
        </p>
    </div>
    
<?php } ?>