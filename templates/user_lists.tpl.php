<?php function drawUsersPage(PDO $db) {
    ?><main id="user-list-page"><?php
    $users = Client::getAllClientsInfo($db);
    drawUsersList($db, $users);
    ?></main><?php
    drawOptionsBar();
} ?>

<?php function drawAgentsPage(PDO $db) {
    ?><main id="user-list-page"><?php
    $users = Agent::getAllAgents($db);
    drawUsersList($db,$users);
    ?></main><?php
    drawOptionsBar();
} ?>

<?php function drawUsersList(PDO $db, $users) {
    if ($users == null) {
        echo '<p class="Warning">There are no users yet!</p>';
        return;
    } 
?>  
    <table id="user-list">
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
            <tr class="user-list-element">
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
<?php } ?>

<?php function drawOptionsBar() { ?>
    <div id="options-bar">
        <div id="top-side">
            <h3>Options</h3>
        </div>
        <div id="bottom-side">
            <button type="button" id="toggle-select" class="list-button"><i class="fa-solid fa-square-check"></i> Toggle Select</button> 
            <button type="button" id="select-all" class="list-button"><i class="fa-solid fa-square-check"></i> Select All</button> 
            <button type="button" id="edit-button" class="list-button"><i class="fa-solid fa-pencil"></i> Edit</button> 
            <button type="button" id="save-button" class="list-button"><i class="fa-solid fa-floppy-disk"></i> Save</button> 
            <button type="button" id="cancel-button" class="list-button"><i class="fa-solid fa-rectangle-xmark"></i> Cancel</button> 
        </div>
    </div>
<?php } ?>