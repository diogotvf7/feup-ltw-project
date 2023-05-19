<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/ticket.tpl.php');
    require_once(__DIR__ . '/../templates/user_lists.tpl.php');
    require_once (__DIR__ . '/../database/user.class.php');
    require_once (__DIR__ . '/../database/ticket.class.php');
    require_once(__DIR__ . '/../database/tag.class.php');

    if (!Session::isLoggedIn())
        die(header('Location: /pages/login.php'));
    if ($_SESSION['PERMISSIONS'] != 'Admin') 
        die(header('Location: /pages/my_tickets.php'));
    drawHeader(['admin_page'], ['style']);
    ?>
    <main class="content">
        <div class="column">
            <div class = "dropdown">
                <button name="dropbtn" class="dropbtn" > <i class="fa-sharp fa-solid fa-plus"></i> Create </button>
                <div class="dropdown-content" hidden>
                    <button class="dropdown-button" id="create-department" type="button">Create Department</button>
                    <button class="dropdown-button" type="button">Create Status</button>
                </div>
            </div>
            <div class="table">
                <table class="department-table">
                    <tbody class="table-body">
                        <tr id="table-header">
                            <th>Name of Department</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-popup" id="myForm">
            <form action="../actions/create_department.php" id="newDepartmentForm" class="form-container" method="post">
                <h1>New Department</h1>

                <label for="department-name"><b>Department Name</b></label>
                <input type="text" placeholder="Enter new department name" id="department-name" name="department-name" required>
            
                <button type="submit" id="submit_create_department" class="btn">Create new department</button>
                <button type="button" id="cancel-creation-department" class="btn cancel">Close</button>
            </form>
        </div>
        <div class="form-popup" id="add-member-popup">
            <form action="../actions/add_member_department.php" id="addtoDepartmentForm" class="form-container" method="post">
                <h1 id="assign-header">Add to </h1>

                <label for="department-name"><b>Select the members you want to assign</b></label>
                <select name='type' id="assign-dropdown" required multiple='multiple'>
                </select>
            
                <button type="submit" id="submit_assign" class="btn">Assign to department</button>
                <button type="button" id="cancel-assign-department" class="btn cancel">Close</button>
            </form>
        </div>
    </main>

    <?php
    drawNavBar($_SESSION['PERMISSIONS']);

    drawFooter();
?>