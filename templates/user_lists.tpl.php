<?php

    // require_once(__DIR__ . '/../database/Client.class.php');
    // require_once(__DIR__ . '/../database/Agent.class.php');
    // require_once(__DIR__ . '/../database/Admin.class.php');
?>

<?php function drawUsersList(PDO $db, $users) {
    // $users = Client::getAllClientsInfo($db); 
    if ($users == null) {
        echo '<p class="Warning">There are no users yet!</p>';
        return;
    } 
?>  
    <div id="user-list-page">
        <div id="user-list-buttons">
            <button type="button" id="toggle-select"><i class="fa-solid fa-square-check"></i> Toggle Select</button> 
            <button type="button" id="select-all"><i class="fa-solid fa-square-check"></i> Select All</button> 
            <button type="button" id="edit-button"><i class="fa-solid fa-pencil"></i> Edit</button> 
            <button type="button" id="save-button"><i class="fa-solid fa-floppy-disk"></i> Save</button> 
        </div>
        <table id="users-list">
            <tr id="table-header">
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tickets made</th>
                <th>Tickets in charge</th>
            </tr>
            <?php foreach($users as $user) { ?>
                <tr class="users-list-element">
                    <td><input type="checkbox" name="select-user"></td>
                    <td><?= $user['ClientID'] ?></td>
                    <td><?= $user['Name'] ?></td>
                    <td><?= $user['Username'] ?></td>
                    <td><?= $user['Email'] ?></td>
                    <td><?= getUserType($db, $user['ClientID']) ?></td>
                    <td><?= $user['Tickets_made'] ?></td>
                    <td><?= $user['Tickets_in_charge'] == NULL ? '-' : $user['Tickets_in_charge'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>
