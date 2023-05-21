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
        <div id="ticket-list">
        </div>
<?php } ?>

<?php function drawTicketPage() { ?>
    <main id="ticket-page">
        <button id="edit-ticket"><i class="fa-solid fa-pen-to-square"></i></button>
        <button id="cancel-edit-ticket" type="button" hidden><i class="fa-solid fa-xmark"></i></button>
        <form id="ticket-form" action="../actions/edit_ticket.php" method="post">
            <button id="save-ticket" hidden><i class="fa-solid fa-floppy-disk"></i></button>
            <header>
                <input type="text" name="title" id="title" maxlength="27" disabled required></input>
                <div class="flex align-center">
                    <label for="status-select">Status:</label>
                    <select id="status-select" name="status" disabled>
                    </select>
                </div>
                <p id="date"></p>
            </header>
            <body>
                <textarea name="description" id="description" disabled required></textarea>
                <div class="space-between align-center">
                    <div id="tags"></div>
                    <div >
                        <div class="autocomplete">
                            <input id="tags-search" type="text" placeholder="Tag" hidden>
                        </div>
                        <button id="add-tag" type="button" hidden><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <div class="flex align-center">
                        <label for="department-select">Department:</label>
                        <select id="department-select" name="department" disabled>
                        </select>
                    </div>
                    <p id="author"></p>
                    <div class="flex align-center">
                        <label for="agent-select">Agent:</label>
                        <select id="agent-select" name="agent" disabled>
                        </select>
                    </div>
                </div>
                <div id="documents-list"></div> 
            </body>
        </form>
        <footer>
            <div id="log">
            </div>
            <form id="new-comment" method="post" enctype="multipart/form-data" action="../actions/action_submit_comment.php">
                <textarea placeholder="Type your Message Here...." name="comment" required></textarea>
                <div>
                    <input type="file" 
                        id="submitted-files" 
                        name="files[]"
                        accept="application/pdf, image/png, image/jpeg, image/gif"
                        multiple>
                    <button id="submit" name="files_submitted" type="submit" data-submit="...Sending">Submit</button>
                </div>
            </form>
        </footer>
            
        
    </main>
<?php } ?>

<?php function drawNewTicketPage($db) { ?>
    <main id="new-ticket-page">
        <form id="new-ticket" method="post" enctype="multipart/form-data" action="../actions/submit_ticket.php"> 
            <h3>New Ticket</h3>
            <fieldset>
                <legend id = description>Fill in the following fields to create a new ticket</legend>
                <input placeholder="Title" type="text" name="ticket_title" tabindex="1" maxlength="27" required autofocus>
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
                <div>
                    <select name="tags[]" id="tags" multiple>
                    </select>
                </div>
                <button id="submit" name="files_submitted" type="submit" data-submit="...Sending">Submit</button>
            </fieldset>        
        </form>
    </main>
    <script src="../javascript/new_ticket.js"></script>
<?php } ?>

<?php function drawFiltersBar() { ?>
    <div id="filters-bar">
        <div id="top-side">
            <h3>Filters</h3>
            <form method="get" id="filter-form">
                <div class="space-between">
                    <label for="date-input-lb">From: </label>
                    <input id="date-input-lb" type="date" id="from" name="dateLowerBound">
                </div>
                <div class="space-between">
                    <label for="date-input-ub">To: </label>
                    <input id="date-input-ub" type="date" id="to" name="dateUpperBound">
                </div>
                <label for="status-select">Status:</label>
                <select id="status-select" name="status">
                    <option value="">All</option>
                    <!-- <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                    <option value="In progress">In progress</option> -->
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
                    <option value="">-</option>
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
