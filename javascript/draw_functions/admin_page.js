import { fetch_department_api, fetch_user_api } from '../api/fetch_api.js';

export function createDepartmentTableRow(department, usersInDepartment) {
    const tr = document.createElement('tr'); // row
    tr.classList.add('department-table-row');

    const tdName = document.createElement('td'); // row > name
    tdName.textContent = department.Name;

    const tdMembers = document.createElement('td'); // row > members
    tdMembers.classList.add('department-members');

    const teamButton = document.createElement('button'); // row > members > team button
    teamButton.classList.add('team-button');
    teamButton.title = 'Team members';
    
    const teamIcon = document.createElement('i'); // row > members > team button > icon
    teamIcon.classList.add('fa-solid', 'fa-people-group');
    teamButton.appendChild(teamIcon);

    const membersList = document.createElement('div');  // row > members > members list
    membersList.classList.add('members-list');
    membersList.hidden = true;

    for (const user of usersInDepartment) {
        const member = document.createElement('p');
        member.classList.add('member', 'space-between');
        member.title = user.Email;
        member.textContent = user.Username;

        const removeAgentButton = document.createElement('button');
        removeAgentButton.classList.add('remove-agent-button');
        removeAgentButton.title = `Remove ${user.Username} from ${department.Name}`;

        const removeIcon = document.createElement('i');
        removeIcon.classList.add('fa-solid', 'fa-minus');
        removeAgentButton.appendChild(removeIcon);

        removeAgentButton.addEventListener('click', () => { 
            fetch_department_api({
                func: 'remove_user',
                departmentID: department.DepartmentID,
                userID: user.ClientID
            });
            member.remove();
        });
        member.appendChild(removeAgentButton);

        membersList.appendChild(member);
    }

    const newMember = document.createElement('p');
    newMember.classList.add('new-member', 'space-between');
    newMember.textContent = 'Add member';

    const addMemberButton = document.createElement('button');
    addMemberButton.classList.add('add-member');
    addMemberButton.title = `Add member to ${department.Name}`;
    
    const addIcon = document.createElement('i');
    addIcon.classList.add('fa-solid', 'fa-plus');
    addMemberButton.appendChild(addIcon);

    addMemberButton.addEventListener('click', async () => {
        const main = document.querySelector('main');
        const form = await drawAssignToDepartmentForm(department, membersList);
        main.appendChild(form);
    });

    newMember.appendChild(addMemberButton);
    membersList.appendChild(newMember);

    teamButton.addEventListener('click', () => {
        membersList.toggleAttribute('hidden');
    });

    tdMembers.appendChild(teamButton);
    tdMembers.appendChild(membersList);

    const tdDeleteDepartment = document.createElement('td'); // row > delete
    tdDeleteDepartment.classList.add('delete-department');

    const deleteButton = document.createElement('button'); // row > delete > delete button
    deleteButton.classList.add('delete-button');
    deleteButton.title = `Delete ${department.Name}`;

    const deleteIcon = document.createElement('i'); // row > delete > delete button > icon
    deleteIcon.classList.add('fa-solid', 'fa-trash');
    deleteButton.appendChild(deleteIcon);

    deleteButton.addEventListener('click', () => {
        fetch_department_api({
            func: 'remove_department',
            departmentID: department.DepartmentID
        });
        tr.remove();
    });
    tdDeleteDepartment.appendChild(deleteButton);
    
    tr.appendChild(tdName);
    tr.appendChild(tdMembers);
    tr.appendChild(tdDeleteDepartment);

    return tr;
}

async function drawAssignToDepartmentForm(department, membersList) {
    const agents = await fetch_user_api({func: 'getAgents'});

    const form = document.createElement('form');
    form.action = '../actions/add_user_department.php';
    form.id = 'addtoDepartmentForm';
    form.classList.add('form-container');
    form.method = 'post';

    const header = document.createElement('h1');
    header.id = 'assign-header';
    header.textContent = 'Assign members';

    const departmentLabel = document.createElement('label');
    departmentLabel.for = 'department-name';
    departmentLabel.textContent = 'Department';

    const departmentInput = document.createElement('input');
    departmentInput.type = 'text';
    departmentInput.id = 'department-name';
    departmentInput.disabled = true;
    departmentInput.value = department.Name;

    const membersLabel = document.createElement('label');
    membersLabel.for = 'department-name';
    membersLabel.textContent = 'Members';

    const membersDropdown = document.createElement('select');
    membersDropdown.name = 'members[]';
    membersDropdown.id = 'assign-dropdown';
    membersDropdown.required = true;
    membersDropdown.multiple = true;

    for (const agent of agents['agents']) {
        const option = document.createElement('option');
        option.value = agent.id;
        option.textContent = agent.username;
        console.log(membersList.textContent)
        if (membersList.textContent.includes(agent.username)) {
            option.disabled = true;
        }
        membersDropdown.appendChild(option);
    }
    
    const submitButton = document.createElement('button');
    submitButton.type = 'button';
    submitButton.id = 'submit_assign';
    submitButton.classList.add('btn');
    submitButton.textContent = 'Assign to department';

    submitButton.addEventListener('click', () => {
        const selected = Array.from(membersDropdown.selectedOptions);
        const members = selected.map(option => option.value);
        const departmentID = department.DepartmentID;

        for (const member of members) {
            fetch_department_api({
                func: 'add_user_to_department',
                departmentID: departmentID,
                userID: member
            });
        }
        location.reload();
    });

    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.id = 'cancel-assign-department';
    cancelButton.classList.add('btn', 'cancel');
    cancelButton.textContent = 'Close';

    cancelButton.addEventListener('click', () => {
        form.remove();
    });

    form.appendChild(header);
    form.appendChild(departmentLabel);
    form.appendChild(departmentInput);
    form.appendChild(membersLabel);
    form.appendChild(membersDropdown);
    form.appendChild(submitButton);
    form.appendChild(cancelButton);

    return form;
}

export function createAddDepartmentForm() {
    let previousForm = document.querySelector('form');
    if (previousForm) previousForm.remove();

    const form = document.createElement('form');
    form.action = '../actions/create_department.php';
    form.id = 'newDepartmentForm';
    form.classList.add('form-container');
    form.method = 'post';

    const header = document.createElement('h1');
    header.textContent = 'New Department';
    
    const nameLabel = document.createElement('label');
    nameLabel.for = 'department-name';
    nameLabel.textContent = 'Department Name';

    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.placeholder = 'Enter new department name';
    nameInput.id = 'department-name';
    nameInput.name = 'departmentName';
    nameInput.required = true;

    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.id = 'submit_create_department';
    submitButton.classList.add('btn');
    submitButton.textContent = 'Create new department';

    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.id = 'cancel-creation-department';
    cancelButton.classList.add('btn', 'cancel');
    cancelButton.textContent = 'Close';
    
    cancelButton.addEventListener('click', () => {
        form.remove();
    });

    form.addEventListener('submit', () => {
        location.reload();
    });

    form.appendChild(header);
    form.appendChild(nameLabel);
    form.appendChild(nameInput);
    form.appendChild(submitButton);
    form.appendChild(cancelButton);

    return form;
}

export function createAddStatusForm() {
    let previousForm = document.querySelector('form');
    if (previousForm) previousForm.remove();

    const form = document.createElement('form');
    form.action = '../actions/create_status.php';
    form.id = 'newStatusForm';
    form.classList.add('form-container');
    form.method = 'post';

    const header = document.createElement('h1');
    header.textContent = 'New Status';
    
    const nameLabel = document.createElement('label');
    nameLabel.for = 'status-name';
    nameLabel.textContent = 'Status Name';

    const nameInput = document.createElement('input');
    nameInput.type = 'text';
    nameInput.placeholder = 'Enter new status name';
    nameInput.id = 'status-name';
    nameInput.name = 'statusName';
    nameInput.required = true;

    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.id = 'submit_create_status';
    submitButton.classList.add('btn');
    submitButton.textContent = 'Create new status';

    const cancelButton = document.createElement('button');
    cancelButton.type = 'button';
    cancelButton.id = 'cancel-creation-status';
    cancelButton.classList.add('btn', 'cancel');
    cancelButton.textContent = 'Close';
    
    cancelButton.addEventListener('click', () => {
        form.remove();
    });

    form.addEventListener('submit', () => {
        location.reload();
    });

    form.appendChild(header);
    form.appendChild(nameLabel);
    form.appendChild(nameInput);
    form.appendChild(submitButton);
    form.appendChild(cancelButton);

    return form;
}