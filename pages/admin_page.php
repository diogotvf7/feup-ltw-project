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
                    <a href="#" onclick="openForm()">Create Department</a>
                    <a href="aaa.php">Create Status</a>
                    
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
            <form action="../actions/create_department.php" class="form-container" method="post">
                <h1>New Department</h1>

                <label for="department-name"><b>Department Name</b></label>
                <input type="text" placeholder="Enter new department name" id="department-name" name="department-name" required>
            
                <button type="submit" onclick="closeForm()" class="btn">Create new department</button>
                <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            </form>
        </div>
    </main>

    <?php
    drawNavBar($_SESSION['PERMISSIONS']);

    drawFooter();
?>