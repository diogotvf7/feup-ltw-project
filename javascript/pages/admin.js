import { }

window.onload = async function() {

}
















<div class="form-popup" id="myForm">
<form action="../actions/create_department.php" id="newDepartmentForm" class="form-container" method="post">
    <h1>New Department</h1>

    <label for="department-name"><b>Department Name</b></label>
    <input type="text" placeholder="Enter new department name" id="department-name" name="department-name" required>

    <button type="button" id="submit_create_department" class="btn">Create new department</button>
    <button type="button" id="cancel-creation-department" class="btn cancel">Close</button>
</form>
</div>
<div class="form-popup" id="add-member-popup">
<form action="../actions/add_user_department.php" id="addtoDepartmentForm" class="form-container" method="post">
    <h1 id="assign-header">Assign members</h1>
    <label for="department-name"><b>Department</b></label>
    <input type="text" id="department-name" disabled></input>
    <label for="department-name"><b>Members</b></label>
    <select name='members[]' id="assign-dropdown" required multiple>
    </select>

    <button type="button" id="submit_assign" class="btn">Assign to department</button>
    <button type="button" id="cancel-assign-department" class="btn cancel">Close</button>
</form>
</div>
</main>

<div id="popup" hidden>
<h3> Department created </h3>
<p> Assign members now!</p>
</div>