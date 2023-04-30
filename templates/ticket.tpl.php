<?php 
    require_once(__DIR__ . '/../database/tag.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/client.class.php');
    require_once(__DIR__ . '/../database/agent.class.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');
?>

<?php function drawTicketPreview($db, $id) { 
    $ticket = Ticket::getTicketData($db, $id);
    $tags = Ticket::getTicketTags($db, $ticket->id);
    $author = Client::getClient($db, $ticket->clientId);
    // $department = Department::getDepartment($db, $ticket->departmentId);
?>
    <a class="ticket-list-element" href="ticket_page.php?id=<?=$id;?>">
        <h3 class="title">
            <?=$ticket->title?>
        </h3>
        <p class="time">
            <?=timeAgo($ticket->date)?>
        </p>
        <p class="description">
            <?=removeOverflow($ticket->description, 60)?>
        </p>
        <div class="tags">
        <p class="status">
            <?=$ticket->status?>
        </p>
        <?php 
            if ($tags != null)
                foreach ($tags as $tag)
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
        <div id="info"> 
            <p class="status"><?=$ticket->status;?></p>
            <div class="tags">
                <?php foreach ($tags as $tag) {
                    echo '<p class="tag">' . $tag['Name'] . '</p>';
                }?>
            </div>
            <p>Department: <?=$department->name;?></p>
            <p>By: <?='@' . $author->username;?></p>
            <p>Currently assigned to: <?='@' . $agent->username;?></p>
        </div>
        <div id="documents">
            <?php if ($documents != null) { ?>
                <h2> 
                    Documents 
                </h2>
                <ul id="image-list">
                    <?php foreach ($documents as $document)
                        echo  '<img class="image-list-element" height="300" src="../' . $document['Path'] . '">';
                    ?>
                </ul>
            <?php } ?>
        </div>
        <div class="date">
            <p>Created: <?=displayDate($ticket->date);?></p>
            <!-- <p>Last updated: <?=''#timeAgo($ticket->lastUpdate);?></p> -->
        </div>
    </div>
    
<?php } ?>