
window.onload = async function() {
  
  await loadDepartments();
  const teamButton = document.querySelectorAll('[class="team-button"]');
  const TeamInfo = document.querySelectorAll('[class="team-info"]');
  /* create deparment form */
  const create_department_button = document.getElementById('create-department');
  const cancel_creation_department = document.getElementById('cancel-creation-department');
  const submit_button = document.getElementById('submit_create_department');
  create_department_button.addEventListener('click', function() {document.getElementById("myForm").style.display = "block";});
  cancel_creation_department.addEventListener('click', function() {document.getElementById("myForm").style.display = "none"; document.getElementById("department-name").value = "";});
  submit_button.addEventListener('click',function() {document.getElementById("myForm").style.display = "none"; document.getElementById("department-name").value = "";});
  /* assign to department form */
  const submit_assign_button = document.getElementById('submit_assign');
  const cancel_assign_department_button = document.getElementById('cancel-assign-department');
  submit_assign_button.addEventListener('click', function(){document.getElementById("add-member-popup").style.display = "none"; });
  cancel_assign_department_button.addEventListener('click', function(){document.getElementById("add-member-popup").style.display = "none";});

  for (const button of teamButton) {
    button.addEventListener('click', function() {
      let team_Info = button.nextSibling;
      if (team_Info.hasAttribute('hidden') === true) {
        console.log('hey');
        team_Info.toggleAttribute('hidden');
      } 
      else if (team_Info.hasAttribute('hidden') === false) {
        console.log('clicked to false');
        team_Info.setAttribute('hidden', true);
      }
    });
    button.addEventListener('touchend', function() {
      let team_Info = button.nextSibling;
      if (team_Info.hasAttribute('hidden') === true) {
        team_Info.toggleAttribute('hidden');
      } 
      else if (team_Info.hasAttribute('hidden') === false) {
        team_Info.setAttribute('hidden', false);
      }
    });
  }

  const minusIcon = document.querySelectorAll('[id="minus-icon"]');
  for (const icon of minusIcon) {
    icon.addEventListener('click', function() {
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
          
        });  
  }
  const addMemberButton = document.querySelectorAll('[id="add-member"]');
      
  for (const button of addMemberButton) {
    button.addEventListener('click', function() {
      document.getElementById('add-member-popup').style.display = "block";
      let department_nm = "";
      for (const btn of teamButton){
        let team_Info = btn.nextSibling;
        if (team_Info.hasAttribute('hidden') === false) {
          department_nm = team_Info.
          team_Info.setAttribute('hidden', true);
        }
      }
      document.getElementById('assign-header').value += 
    });
  }
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
        button.setAttribute('class', 'team-button');
        button.title = 'Team members';
        const icon = document.createElement('i');
        icon.classList.add('fa-solid', 'fa-people-group');
        const teamInfo = document.createElement('div');
        teamInfo.setAttribute('class', 'team-info');
        for (const user of usersInDepartment) {
          const teamMember = document.createElement('div');
          const member = document.createElement('p');
          member.setAttribute('id', user['ClientID']);
          member.classList.add('space-between');
          
          member.title = user['Email'];
          member.textContent = user['Name'];
          
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

// teamButton.addEventListener('click', function() {
//   console.log('clicked');
//   if (TeamInfo.hasAttribute('hidden') === true) {
//     TeamInfo.setAttribute('hidden', 'false');
//   } else {
//     TeamInfo.setAttribute('hidden', 'true');
//   }
// });


