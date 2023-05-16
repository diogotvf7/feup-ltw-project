<?php function drawUsersPage($users) {
    ?><main id="user-list-page"><?php
    drawUsersList($users);
    ?></main><?php
    drawOptionsBar();
} ?>

<?php function drawAgentsPage($agents) {
    ?><main id="user-list-page"><?php
    drawUsersList($agents, true);
    ?></main><?php
    drawOptionsBar();
} ?>

<?php function drawUsersList($users, $agents = false) {
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
            <?= $agents ? '<th>Department</th>' : '' ?>
            <?= $agents
            ? '<th>Tickets in charge</th><th>Tickets open</th><th>Tickets closed</th>' 
            : '<th>Tickets made</th>' ?>
        </tr>
        <?php foreach($users as $user) { ?>
            <tr class="user-list-element">
                <td><input type="checkbox" name="select-user"></td>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->type ?></td>
                <?= $agents ? '<td> - </td>' : '' ?>
                <td> - </td>
                <?= $agents 
                ? '<td> - </td><td> - </td>'
                : '' ?>
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
            <button type="button" id="remove-user-button" class="list-button"><i class="fa-solid fa-user-xmark"></i> Remove user</button> 
            <button type="button" id="save-button" class="list-button"><i class="fa-solid fa-floppy-disk"></i> Save</button> 
            <button type="button" id="cancel-button" class="list-button"><i class="fa-solid fa-rectangle-xmark"></i> Cancel</button> 
        </div>
    </div>
<?php } ?>