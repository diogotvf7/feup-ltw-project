import { fetch_department_api } from '../api/fetch_api.js';

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
        member.classList.add('member');
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
