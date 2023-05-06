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
    if ($ticket->agentId != null) $agent = Agent::getAgent($db, $ticket->agentId);
    if ($ticket->departmentId != null) $department = Department::getDepartment($db, $ticket->departmentId);
    ?>

    <div id="ticket">
        <h1> 
            <?=$ticket->title;?> 
        </h1>
        <label id="description-label" for="description">Ticket description</label>
        <p id="description"> 
            <?=$ticket->description;?>
        </p>
        <div id="info"> 
            <p class="status"><?=$ticket->status;?></p>
            <!-- <select class="status"> 
                <option value="option1" > </*?=$ticket->status;?*/> </option>
                <option value="option2"> </*?php echo ($ticket->status == "Open") ? "Closed" : "Open"; */?> </option>
            </select> -->
            <div class="tags">
                <?php foreach ($tags as $tag) {
                    echo '<p class="tag">' . $tag['Name'] . '</p>';
                }?>
            </div>
            <?php if ($department != null) ?><p>Department: <?=$department->name;?></p>
            <!-- <label for="departmentCh">Department</label>
            <select name="departmentChoice" id="departmentCh" class="department"> 
                <option value="option1" ><?= $department == null ? "" : $department->name;?> </option>
                <option value="option2"> Eventos </option>
            </select> -->
            <p>By: <?='@' . $author->username;?></p>
            <p>Currently assigned to: <?='@' . $agent == null ? "" : $agent->username;?></p>
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

<?php function createNewTicket($db) { ?>

    <body id = "ticket-page">
    <div class= "container">
        <form id="new-ticket" method="post" enctype="multipart/form-data" action="../actions/submit_ticket.php"> 
            <h3>New Ticket</h3>
            <h4 id = description>Fill in the following fields to create a new ticket</h4>
            <fieldset>
                <input placeholder="Title of ticket" type="text" name="ticket_title" tabindex="1" required autofocus>
            </fieldset>
            <fieldset>
            <select id="department" name="ticket_department">
            <option value="" selected>Select a department</option>
            <?php
            $departments = Department::getAllDepartments($db);
            foreach ($departments as $department) {
                echo "<option value=\"" . $department['Name'] . "\">" . $department['Name'] . "</option>";
            }
            ?>
            </select>
            </fieldset>
            <fieldset>
                <textarea placeholder="Type your Message Here...." name="ticket_description" tabindex="3" required></textarea>
            </fieldset>
            <fieldset>
                <input type="file" id="submitted-files" name="files[]" multiple>
            </fieldset> 
            <fieldset>
                <button id="submit" name="files_submitted" type="submit" data-submit="...Sending">Submit</button>
            </fieldset>        
        </form>
    </div>
    <?php } ?>