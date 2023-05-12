<?php 
    require_once(__DIR__ . '/../database/tag.class.php');
    require_once(__DIR__ . '/../database/department.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../utils/util_funcs.php');
?>

<?php function drawTicketsListPage() {
  ?><main id="ticket-list-page"><?php
  drawTicketsList();
  drawFiltersBar();
  ?></main><?php
} ?>

<?php function drawTicketsList() { ?>
        <ul id="ticket-list">
        </ul>
<?php } ?>

<?php function drawTicket($db, $ticketId) {
    $ticket = Ticket::getTicketData($db, $ticketId);
    $tags = Ticket::getTicketTags($db, $ticketId);
    $documents = Ticket::getDocuments($db, $ticketId);
    $author = User::getUser($db, $ticketId);
    if ($ticket->agentId != null) $agent = User::getUser($db, $ticket->agentId);
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
            <?= $department == null ? '<p>No department</p>' : '<p>Department: ' . $department->name . '</p>';?>
            <p>By: <?='@' . $author->username;?></p>
             <?= $agent == null ? 'This ticket isn\'t assigned' : '<p>Currently assigned to: @' . $agent->username . '</p>';?>
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

<?php function drawNewTicketPage($db) { ?>
    <main id="new-ticket-page">
        <form id="new-ticket" method="post" enctype="multipart/form-data" action="../actions/submit_ticket.php"> 
            <h3>New Ticket</h3>
            <fieldset>
                <legend id = description>Fill in the following fields to create a new ticket</legend>
                <input placeholder="Title" type="text" name="ticket_title" tabindex="1" required autofocus>
                <textarea placeholder="Type your Message Here...." name="ticket_description" tabindex="3" required></textarea>
                <span id="horizontal">
                    <input type="file" 
                            id="submitted-files" 
                            name="files[]"
                            accept="application/pdf, image/png, image/jpeg, image/gif" 
                            multiple>
                    <select id="department" name="ticket_department">
                        <option value="" selected>Select a department</option>
                        <?php
                            $departments = Department::getAllDepartments($db);
                            foreach ($departments as $department) 
                                echo "<option value=\"" . $department['Name'] . "\">" . $department['Name'] . "</option>";
                            
                        ?>
                    </select>
                </span>
                <button id="submit" name="files_submitted" type="submit" data-submit="...Sending">Submit</button>
            </fieldset>        
        </form>
    </main>
<?php } ?>

<?php function drawFiltersBar() { ?>
    <div id="filters-bar">
        <div id="top-side">
            <h3>Filters</h3>
            <form method="get" id="filter-form">
                <div class="space-between">
                    <label for="from">From: </label>
                    <input id="date-input" type="date" id="from" name="dateLowerBound">
                </div>
                <div class="space-between">
                    <label for="to">To: </label>
                    <input id="date-input" type="date" id="to" name="dateUpperBound">
                </div>
                <label for="status">Status:</label>
                <select id="status-select" name="status">
                    <option value="">All</option>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select> 
                <label for="department-select">Department:</label>
                <select id="department-select" name="department">
                    <option value=""></option>
                </select> 
                <label for="tag-select">Tags:</label>
                <select id="tag-select" name="tag" multiple>
                </select> 
                <label for="sort">Sort by:</label>
                <select id="sort" name="sort">
                    <option value=""></option>
                    <option value="DESC" selected>Most recent first</option>
                    <option value="ASC">Oldest first</option>
                </select> 
                <button class="" type="submit"><i class="fa-solid fa-filter"></i>Filter</button>
            </form>
        </div>
        <div id="bottom-side">
            <button id="new-ticket-button" onclick="window.location.href='new_ticket.php'"><i class="fa-solid fa-plus"></i> New ticket</button>
        </div>
    </div>
<?php } ?>