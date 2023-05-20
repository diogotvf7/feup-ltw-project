const TeamInfo = document.querySelectorAll('[class="team-info"]');

window.onload = async function() {
  await loadDepartments();
  const teamButton = document.querySelectorAll('[class="team-button"]');
  /* create deparment form */
  const create_department_button = document.getElementById('create-department');
  const cancel_creation_department = document.getElementById('cancel-creation-department');
  const submit_button = document.getElementById('submit_create_department');
  create_department_button.addEventListener('click', function() {document.getElementById("myForm").style.display = "block";});
  cancel_creation_department.addEventListener('click', function() {document.getElementById("myForm").style.display = "none"; document.getElementById("department-name").value = "";});
  /* assign to department form */
  const submit_assign_button = document.getElementById('submit_assign');
  const cancel_assign_department_button = document.getElementById('cancel-assign-department');
  
  cancel_assign_department_button.addEventListener('click', function(){document.getElementById("add-member-popup").style.display = "none";});
  const tableRows = document.querySelectorAll('.department-table-row');
  let currentOpenTab = null;
  /*
  for (const button of teamButton) {
    button.addEventListener('click', function() {
      let team_Info = button.nextSibling;
      if (team_Info.hasAttribute('hidden') === true) {
        team_Info.toggleAttribute('hidden');
      } 
      else if (team_Info.hasAttribute('hidden') === false) {
        team_Info.toggleAttribute('hidden');
      }
    });
  }
  */




  /* create deparment  */

  submit_button.addEventListener('click', async function() {
    let departmentName = document.getElementById("department-name").value;
    let data = {
      departmentName: departmentName
    };
    console.log(departmentName)

    fetch('../actions/create_department.php', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-type': 'application/json; charset=UTF-8'
      }
    }).then(async function(response) {
        let res = await response.json();
        console.log(res.status)
      if (res.status == 'success') {
        const table = document.querySelector('[class="department-table"]');
        const row = document.createElement('tr');
        row.id = res['departmentID'];
        row.classList.add('department-table-row');

        let department_name = document.createElement('td');
        department_name.textContent = departmentName;

        row.appendChild(department_name);

        let department_members = document.createElement('td');
        department_members.classList.add('department-table-info');
        let team_button = document.createElement('button');
        team_button.classList.add('team-button');
        team_button.title = 'Team Members';
        let team_icon = document.createElement('i');
        team_icon.classList.add('fa-solid','fa-people-group');
        team_button.appendChild(team_icon);
        department_members.appendChild(team_button);
        let team_info = document.createElement('div');
        team_info.classList.add('team-info');
        team_info.setAttribute('hidden', true);
        team_info.id = res['departmentID'];
        department_members.appendChild(team_info);
        row.appendChild(department_members);
        table.appendChild(row);
        console.log(row);
      }
    });

    document.getElementById("myForm").style.display = "none"; 
    document.getElementById("department-name").value = "";
  });


  /* remove user from department */
  const departmentTable = document.querySelector('[class="department-table"]');

  departmentTable.addEventListener('click', function(event) {
    /* click on minus icon*/
    const target = event.target;
        if (target.id === 'minus-icon') {
          let icon = target;
          let member_info = icon.parentNode;
      
          let userID = member_info.id;
          let departmentID = member_info.parentNode.parentNode.parentNode.id;
          
          let data = {
            userID: userID,
            departmentID: departmentID
          };
          
          fetch('../actions/remove_user_department.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
              'Content-type': 'application/json; charset=UTF-8'
            }
          }).then(function(response) {
            if (response.ok) {
              member_info.remove();
            }
          });  
        }
        if (target.id == 'list-members'){
          let icon = target;
          let list_members = icon.nextSibling;
          if (list_members.hasAttribute('hidden') === true) {
            list_members.toggleAttribute('hidden');
          } 
          else if (list_members.hasAttribute('hidden') === false) {
            list_members.toggleAttribute('hidden');
          }
          console.log(list_members);
          
        }
  });  

  const addMemberButton = document.querySelectorAll('[id="add-member"]');
      
  for (const button of addMemberButton) {
    let departmentID = button.parentNode.id; 
    let departmentName = button.parentNode.parentNode.parentNode.firstChild.textContent;
    button.addEventListener('click', async function(event){
      document.getElementById('add-member-popup').style.display = "block";
      let department_nm = "";
      for (const btn of teamButton){
        let team_Info = btn.nextSibling;
        if (team_Info.hasAttribute('hidden') === false) {
          department_nm = team_Info;
          team_Info.setAttribute('hidden', true);
        }
      }
      const select = document.getElementById('assign-dropdown');
      select.innerHTML = "";
      select.parentNode.setAttribute('departmentID',departmentID);
      const form = document.getElementById('addtoDepartmentForm');
      const input = form.querySelector('#department-name');
      input.value = departmentName;
      const response = await fetchAllAgents();
      let agents = response['agents'];
      for (const agent of agents){
        const res = await fetchAgentInfo(agent['id']);
        const agent_departments = res['departments'];
        const departmentIDs = agent_departments.map(obj => obj.DepartmentID);
        const condition = (element) => element == departmentID;
        const result = departmentIDs.some(condition);
        if (result == true) continue;
        const op = document.createElement('option');
        op.classList.add('agent');
        op.textContent = agent['username'];
        op.title = agent['email'];
        select.appendChild(op);
      }
    });
  }

  /* add member to department */

  const submit_assign = document.getElementById('submit_assign');
  submit_assign.addEventListener('click', async function(e){
    if (document.getElementById('assign-dropdown').selectedOptions.length === 0) {e.preventDefault(); return false;};
    let newMembers = Array.from(document.getElementById('assign-dropdown').selectedOptions).map(el => el.value);
    let departmentName =document.getElementById('addtoDepartmentForm').querySelector('#department-name').value;    
    let data = {
      newMembers: newMembers,
      departmentName: departmentName
    };
    
    document.getElementById("add-member-popup").style.display = "none";

    fetch('../actions/add_user_department.php', {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
            'Content-type': 'application/json; charset=UTF-8'
          }
    }).then(function(response) {
      tableRows.forEach( async row => {
        const departmentCell = row.querySelector('td:first-child');
        if (departmentCell.textContent === departmentName) {
          const team = row.querySelector('td:nth-child(2)').querySelector('.team-info');
          for (const memberName of newMembers) {
            let member = document.createElement('p');
            const agentInfo = await fetchAgentInfo_username(memberName);
            member.setAttribute('id', agentInfo['id']);
            member.classList.add('space-between');
            member.textContent = memberName;
            member.title = agentInfo['email'];
            const minus_icon = document.createElement('i');
            minus_icon.id = "minus-icon";
            minus_icon.title = 'Remove ' + agentInfo['name'] + ' from ' + departmentName;
            minus_icon.classList.add('fa-solid', 'fa-minus');

            
            member.appendChild(minus_icon);
            let addMemberButton = team.querySelector('#add-member');
            addMemberButton.parentNode.insertBefore(member, addMemberButton);
          }
        }
      });
    });


    
  });
}

async function fetchAllAgents(){
  const response = await fetch('../pages/api_user.php?' + encodeForAjax({
    func: 'getAgents',
}));
const agents = await response.json();
return agents;
}

async function fetchDepartmentInfo(_id){
  const response = await fetch('../pages/api_department.php?' + encodeForAjax({
      func: 'getDepartmentInfo',
      id: _id,
  }));
  const departmentInfo = await response.json();
  return departmentInfo;
}

async function fetchAgentInfo(id) {
  const response = await fetch('../pages/api_user.php?' + encodeForAjax({
      func: 'getAgentInfo',
      id : id
  }));
  const res = await response.json();
  return res;
}

async function fetchAgentInfo_username(username) {
  const response = await fetch('../pages/api_user.php?' + encodeForAjax({
      func: 'getAgentInfo',
      username : username
  }));
  const res = await response.json();
  return res;
}

async function fetchDepartments() {
  const response = await fetch('../pages/api_department.php?' + encodeForAjax({
      func: 'departments',
  }));
  const departments = await response.json();
  return departments;
}

async function fetchUsersInDepartment(departmentName) {
  const response = await fetch('../pages/api_department.php?' + encodeForAjax({
      func: 'users_in_departments',
      departmentName: departmentName
  }));
  const usersInDepartment = await response.json();
  return usersInDepartment;
}

async function loadDepartments() {
  const departmentTable = document.querySelector('[class="department-table"]');
  const departments = await fetchDepartments();
  const departmentBody = document.querySelector('[class="table-body"]');
  if (departments.length !== 0) {
      for (const department of departments) {
        const usersInDepartment = await fetchUsersInDepartment(department['Name']);
        if (usersInDepartment !== 0){

        const tr = document.createElement('tr');
        tr.setAttribute('id',department['DepartmentID']);
        const departmentName = document.createElement('td');
        tr.setAttribute('class', 'department-table-row');
        departmentName.textContent = department.Name;
        tr.appendChild(departmentName);
        const departmentInfo = document.createElement('td');
        departmentInfo.setAttribute('class', 'department-table-info');
        const button = document.createElement('button');
        button.id = 'list-members';
        button.setAttribute('class', 'team-button');
        button.title = 'Team members';
        const icon = document.createElement('i');
        icon.classList.add('fa-solid', 'fa-people-group');
        const teamInfo = document.createElement('div');
        teamInfo.setAttribute('class', 'team-info');
        teamInfo.id = department.DepartmentID;

        for (const user of usersInDepartment) {
          const teamMember = document.createElement('div');
          const member = document.createElement('p');
          member.setAttribute('id', user['ClientID']);
          member.classList.add('space-between');
          
          member.title = user['Email'];
          member.textContent = user['Username'];
          
          const minus_icon = document.createElement('i');
          minus_icon.id = "minus-icon";
          minus_icon.title = 'Remove ' + user['Name'] + ' from ' + department['Name'];
          minus_icon.classList.add('fa-solid', 'fa-minus');
          
          member.appendChild(minus_icon);
          
          teamMember.appendChild(member);
          teamInfo.appendChild(member);
        }
        const addMember = document.createElement('button');
        addMember.setAttribute('id', 'add-member');
        addMember.textContent = 'Add member';
        addMember.title = 'Add member to ' + department['Name'];
        addMember.classList.add('fa-solid', 'fa-plus');
        teamInfo.appendChild(addMember);
        teamInfo.setAttribute('hidden', 'true');
        button.appendChild(icon);
        departmentInfo.appendChild(button);
        departmentInfo.appendChild(teamInfo);
        tr.appendChild(departmentInfo);
        departmentTable.appendChild(tr);
      }
      }
  }
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
      if (data[k] === null || data[k] === undefined) return;
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}




