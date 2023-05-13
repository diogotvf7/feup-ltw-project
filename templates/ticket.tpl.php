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

<?php function drawTicketPage($db, $ticketId) {
    $ticket = Ticket::getTicketData($db, $ticketId);
    $tags = Ticket::getTicketTags($db, $ticketId);
    $documents = Ticket::getDocuments($db, $ticketId);
    $author = User::getUser($db, $ticket->clientId);
    if ($ticket->agentId != null) $agent = User::getUser($db, $ticket->agentId);
    if ($ticket->departmentId != null) $department = Department::getDepartment($db, $ticket->departmentId);
    ?>
    <main>
        <header>
            <h1 id="title"> 
            </h1>
            <div>
                <select id="status">
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                    <option value="In progress">In progress</option>
                </select>
                <button id="save-button"><i class="fa-solid fa-floppy-disk"></i></button>
            </div>

            <p id="date"></p>
        </header>
        <body>
            <p id="description"></p>
            <div class="space-between">
                <div id="tags"></div>
                <p id="department"></p>
                <p id="author"></p>
                <p id="agent"></p>
            </div>
            <div id="documents-list"></div>            
            <div id="log">
                <!-- log goes here -->
                <!-- insert comment form -->
            </div>
        </body>
    </main>
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
                    <option value="In progress">In progress</option>
                </select> 
                <label for="department-select">Department:</label>
                <select id="department-select" name="department">
                    <option value="">All</option>
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