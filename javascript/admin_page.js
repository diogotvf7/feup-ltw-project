
window.onload = async function() {
  await loadDepartments();
  const teamButton = document.querySelectorAll('[class="team-button"]');
  const TeamInfo = document.querySelector('[class="team-info"]');
  
  for (const button of teamButton) {
    button.addEventListener('click', function() {
      if (TeamInfo.hasAttribute('hidden') === true) {
        console.log('hey');
        TeamInfo.toggleAttribute('hidden');
      } 
      else if (TeamInfo.hasAttribute('hidden') === false) {
        console.log('clicked to false');
        TeamInfo.setAttribute('hidden', true);
      }
    });
  }

}

function openForm() {
    document.getElementById("myForm").style.display = "block";
  }
  
  function closeForm() {
    document.getElementById("myForm").style.display = "none";
  }


  async function fetchDepartments() {
    const response = await fetch('../pages/api_department.php?' + encodeForAjax({
        func: 'departments',
    }));
    const departments = await response.json();
    return departments;
}

async function loadDepartments() {
  const departmentTable = document.querySelector('[class="department-table"]');
  const departments = await fetchDepartments();
  const departmentBody = document.querySelector('[class="table-body"]');
  if (departments.length !== 0) {
      for (const department of departments) {
        const tr = document.createElement('tr');
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
        const teamMember = document.createElement('div');
        const member = document.createElement('p');
        member.textContent = 'John';
        teamMember.appendChild(member);
        teamInfo.setAttribute('class', 'team-info');
        teamInfo.appendChild(member);
        const minus_icon = document.createElement('i');
        minus_icon.classList.add('fa-solid', 'fa-minus');
        minus_icon.setAttribute('class', 'minus-icon');
        member.appendChild(minus_icon);
        teamInfo.setAttribute('hidden', 'true');
        button.appendChild(icon);
        departmentInfo.appendChild(button);
        departmentInfo.appendChild(teamInfo);
        tr.appendChild(departmentInfo);
        departmentTable.appendChild(tr);
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


