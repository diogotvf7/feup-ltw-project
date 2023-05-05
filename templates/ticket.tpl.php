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
            <select class="status"> 
                <option value="option1" ><?=$ticket->status;?> </option>
                <option value="option2"> <?php echo ($ticket->status == "Open") ? "Closed" : "Open"; ?> </option>
            </select>
            <div class="tags">
                <?php foreach ($tags as $tag) {
                    echo '<p class="tag">' . $tag['Name'] . '</p>';
                }?>
            </div>
            <p>Department: <?=$department->name;?></p>
            <label for="departmentCh">Department</label>
            <select name="departmentChoice" id="departmentCh" class="department"> 
                <option value="option1" ><?=$department->name;?> </option>
                <option value="option2"> Eventos </option>
            </select>
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

<?php function createNewTicket($db) { ?>

    <div id="new-ticket">
    <body>
        <form> 
        <label for="title">Title</label>
        <br>
        <input type="text" id="title" name="title" placeholder="Title" required>
        <p><label for="department">Department</label></p>
        <select name="departments">
        <option value="" selected>Select a department</option>
        <?php
        $departments = Department::getAllDepartments($db);
        foreach ($departments as $department) {
            echo "<option value=\"" . $department['Name'] . "\">" . $department['Name'] . "</option>";
        }
        ?>
        </select>
        <form action="">    
        <p><label for="new-ticket">Complaint</label></p>
        <textarea id="text" name="text" rows="4" cols="50" required> </textarea>
        <br>
        <br>
        <form action="/action_page.php">
            <input type="file" id="myFile" name="filename">
        </form>
        <input type="submit" value="Submit">
        </form>
    </body>

    </div>
    <?php } ?>