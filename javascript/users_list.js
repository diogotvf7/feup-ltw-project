edit = document.getElementById("edit-button");
save = document.getElementById("save-button");
selectAll = document.getElementById("select-all");
toggleSelect = document.getElementById("toggle-select");
cancel = document.getElementById("cancel-button");
table = document.getElementById("user-list");
removeUser = document.getElementById("remove-user-button");

window.onload = async function() {
    for (var i = 1, row; row = table.rows[i]; i++) {
        id = row.cells[1].textContent;
        switch (row.cells.length) {
            case 7:
                let clientInfo = await fetchClientInfo(id);
                row.cells[6].textContent = !!clientInfo['made'] ? clientInfo['made'] : '-';
                break;
            case 10:
                let agentInfo = await fetchAgentInfo(id);
                var departments = "";
                for (var j = 0; j < agentInfo['departments'].length; j++) {
                    if (j != 0) departments += ", ";
                    departmentInfo = await fetchDepartmentInfo(agentInfo['departments'][j]['DepartmentID']);
                    departments += departmentInfo['name'];
                }

                console.log(agentInfo)
                console.log(agentInfo['closed'] === null)
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
    for (var i = 1, row; row = table.rows[i]; i++) {
        checkbox = row.cells[0].childNodes[0];
        if (!checkbox.checked) continue;
        for (var j = 2, col; col = row.cells[j] && j < 6; j++) {
            cell = row.cells[j];
            cell.setAttribute("contentEditable", "true");
            cell.style.backgroundColor = "#FFFFCC";
            
            if (j == 5) {
                cell.innerHTML = "";
                var dropdown = document.createElement("select");
                var option1 = document.createElement("option");
                option1.text = "Admin";
                dropdown.add(option1);
                var option2 = document.createElement("option");
                option2.text = "Agent";
                dropdown.add(option2);
                var option3 = document.createElement("option");
                option3.text = "Client";
                dropdown.add(option3);
                cell.appendChild(dropdown);
            }
        }
    }
});

save.addEventListener("click", async function() {
    let rowData = {};
    for (var i = 1, row; row = table.rows[i]; i++) {
        checkbox = row.cells[0].childNodes[0];
        if (!checkbox.checked) continue;
        rowData[1] = row.cells[1].textContent;
        for (var j = 2; j < 6; j++) {
            cell = row.cells[j];
            cell.setAttribute("contentEditable", "false");
            cell.style.backgroundColor = row.cells[0].style.backgroundColor;
            checkbox.checked = false;
            if (j != 5){
                rowData[j] = cell.innerHTML;
            }    
            else {
                var currentOption = cell.querySelector("select").value;
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
    for (var i = 1, row; row = table.rows[i]; i++) {
        var checkbox = row.cells[0].children[0];
        if (!checkbox.checked) continue;
        id = row.cells[1].textContent;
        let user = await fetchUserInfo(id);
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
        row.cells[5].setAttribute("contentEditable", "false");
        row.cells[5].style.backgroundColor = row.cells[0].style.backgroundColor;
        checkbox.checked = false;
    }
});

removeUser.addEventListener("click", function() {
    let usersToRemove = {};
    for (var i = 1, row; row = table.rows[i]; i++) {
        var checkbox = row.cells[0].children[0];
        if (!checkbox.checked) continue;
        usersToRemove[i] = row.cells[1].textContent;
    }
    console.log(usersToRemove);

    const data = {
        usersToRemove : usersToRemove
    };
    
    fetch('../actions/remove_user.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-type': 'application/json; charset=UTF-8'
            }
        });

        });
    

async function fetchUserInfo(_id) {
    const response = await fetch('../pages/api_user.php?' + encodeForAjax({
        func: 'getSingleUser',
        id: _id,
    }));
    const userInfo = await response.json();
    return userInfo;
}

async function fetchAgentInfo(_id) {
    const response = await fetch('../pages/api_user.php?' + encodeForAjax({
        func: 'getAgentInfo',
        id: _id,
    }));
    const agentInfo = await response.json();
    return agentInfo;
}

async function fetchClientInfo(_id) {
    const response = await fetch('../pages/api_user.php?' + encodeForAjax({
        func: 'getClientInfo',
        id: _id,
    }));
    const clientInfo = await response.json();
    return clientInfo;
}

async function fetchDepartmentInfo(_id){
    const response = await fetch('../pages/api_department.php?' + encodeForAjax({
        func: 'getDepartmentInfo',
        id: _id,
    }));
    const departmentInfo = await response.json();
    return departmentInfo;
}