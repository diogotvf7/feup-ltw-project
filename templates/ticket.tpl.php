<?php 
    require_once(__DIR__ . '/../database/tag.class.php');

    require_once(__DIR__ . '/../vendor/autoload.php');
    use Carbon\Carbon;
?>

<?php function drawTicket($db, $id) { 
    $ticket = Ticket::getTicketData($db, $id);
    $tags = Ticket::getTicketTags($db, $ticket->id);
    $author = Client::getClient($db, $ticket->clientId);
?>
    <div class="ticket">
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
            echo '<p class="tag">' . Tag::getTag($db, $tag["TagID"])->name . '</p>';
        ?>
        </div>
        <p class="author">
            <?='@' . $author->username?>  
        </p>
    </div>
<?php } ?>

<?php function drawTicketsList($db, $tickets) { ?>
    <ul id="tickets-list">
        <?php foreach ($tickets as $ticket) {
            drawTicket($db, $ticket["TicketID"]);
        } ?>
    </ul>
<?php } ?>