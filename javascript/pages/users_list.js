import { fetch_user_api } from '../api/fetch_api.js'

const edit = document.getElementById("edit-button");
const save = document.getElementById("save-button");
const selectAll = document.getElementById("select-all");
const toggleSelect = document.getElementById("toggle-select");
const cancel = document.getElementById("cancel-button");
const table = document.getElementById("user-list");
const removeUser = document.getElementById("remove-user-button");

window.onload = async function() {
    for (let i = 1, row; row = table.rows[i]; i++) {
        let id = row.cells[1].textContent;
        switch (row.cells.length) {
            case 7:
                let clientInfo = await fetch_user_api({func: 'getClientInfo', id: id});
                row.cells[6].textContent = !!clientInfo['made'] ? clientInfo['made'] : '-';
                break;
            case 10:
                let agentInfo = await fetch_user_api({func: 'getAgentInfo', id: id});

                let departments = "";
                for (let j = 0; j < agentInfo['departments'].length; j++) {
                    if (j != 0) departments += ", ";
                    console.log(agentInfo['departments'][j]['DepartmentID'] + " " + departments);
                    let departmentInfo = fetchDepartmentInfo(agentInfo['departments'][j]['DepartmentID']);
                    departments += departmentInfo['name'];
                }
                row.cells[6].textContent = departments = "" ? '-' : departments;
                row.cells[7].textContent = !!agentInfo['responsible'] ? agentInfo['responsible'] : '0';
                row.cells[8].textContent = !!agentInfo['open'] ? agentInfo['open'] : '0';
                row.cells[9].textContent = !!agentInfo['closed'] ? agentInfo['closed'] : '0';
                break;
        }
    }
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

edit.addEventListener("click", function() {
    for (let i = 1, row; row = table.rows[i]; i++) {
        let role = row.cells[5].textContent;
        let checkbox = row.cells[0].childNodes[0];
        if (!checkbox.checked) continue;
        for (let j = 2, col; col = row.cells[j] && j < 6; j++) {
            let cell = row.cells[j];
            cell.style.backgroundColor = "#FFFFCC";
            if (j != 5) cell.setAttribute("contentEditable", "true");
            if (j == 5) {
                cell.innerHTML = "";
                let dropdown = document.createElement("select");
                let option1 = document.createElement("option");
                option1.text = "Admin";
                if (role == "Admin") option1.selected = true;
                dropdown.add(option1);
                let option2 = document.createElement("option");
                option2.text = "Agent";
                if (role == "Agent") option2.selected = true;
                dropdown.add(option2);
                let option3 = document.createElement("option");
                option3.text = "Client";
                if (role == "Client") option3.selected = true;
                dropdown.add(option3);
                cell.appendChild(dropdown);
            }
        }
    }
});

save.addEventListener("click", async function() {
    let rowData = {};
    for (let i = 1, row; row = table.rows[i]; i++) {
        let checkbox = row.cells[0].childNodes[0];
        if (!checkbox.checked) continue;
        rowData[1] = row.cells[1].textContent;
        for (let j = 2; j < 6; j++) {
            let cell = row.cells[j];
            cell.style.backgroundColor = row.cells[0].style.backgroundColor;
            checkbox.checked = false;
            if (j != 5){
                rowData[j] = cell.innerHTML;
            }    
            else {
                let currentOption = cell.querySelector("select").value;
                cell.innerHTML = currentOption;
                rowData[j] = currentOption;
            }
        }
    }

    const data = {
        id : rowData[1],
        name: rowData[2],
        username: rowData[3],
        email: rowData[4],
        newRole: rowData[5]
    };
    
    fetch('../actions/update_data.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        })
    });
    
selectAll.addEventListener("click", function() {
    document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
        checkbox.checked = true;
    });
});

toggleSelect.addEventListener("click", function() {
    document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
        checkbox.checked = !checkbox.checked;
    });
});

cancel.addEventListener("click", async function() {
    for (let i = 1, row; row = table.rows[i]; i++) {
        let checkbox = row.cells[0].children[0];
        if (!checkbox.checked) continue;
        let id = row.cells[1].textContent;
        let user = await fetch_user_api({func: 'getSingleUser', id: id});
        // let user = await fetchUserInfo(id);
        row.cells[2].textContent = user['name'];
        row.cells[2].setAttribute("contentEditable", "false");
        row.cells[2].style.backgroundColor = row.cells[0].style.backgroundColor;
        row.cells[3].textContent = user['username'];
        row.cells[3].setAttribute("contentEditable", "false");
        row.cells[3].style.backgroundColor = row.cells[0].style.backgroundColor;
        row.cells[4].textContent = user['email'];
        row.cells[4].setAttribute("contentEditable", "false");
        row.cells[4].style.backgroundColor = row.cells[0].style.backgroundColor;
        row.cells[5].textContent = user['role']; 
        row.cells[5].style.backgroundColor = row.cells[0].style.backgroundColor;
        checkbox.checked = false;
    }
});

removeUser.addEventListener("click", function() {
    let usersToRemove = {};
    let rowsToRemove = [];
    for (let i = 1, row; row = table.rows[i]; i++) {
        let checkbox = row.cells[0].children[0];
        if (!checkbox.checked) continue;
        rowsToRemove.push(row);
        usersToRemove[i] = row.cells[1].textContent;
    }

    for (let i = 0; i < rowsToRemove.length; i++) {
        table.deleteRow(rowsToRemove[i].rowIndex);
    }

    const data = {
        usersToRemove: usersToRemove
    };

    fetch('../actions/remove_user.php', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-type': 'application/json; charset=UTF-8'
        }
    });
});

async function fetchDepartmentInfo(_id){
    const response = await fetch('../pages/api_department.php?' + encodeForAjax({
        func: 'getDepartmentInfo',
        id: _id,
    }));
    const departmentInfo = await response.json();
    return departmentInfo;
}