edit = document.getElementById("edit-button");
save = document.getElementById("save-button");
selectAll = document.getElementById("select-all");
toggleSelect = document.getElementById("toggle-select");
cancel = document.getElementById("cancel-button");
table = document.getElementById("user-list");

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
        }
    }
});

save.addEventListener("click", function() {
    for (var i = 1, row; row = table.rows[i]; i++) {
        checkbox = row.cells[0].childNodes[0];
        if (!checkbox.checked) continue;
        for (var j = 2; j < 6; j++) {
            cell = row.cells[j]; 
            cell.setAttribute("contentEditable", "false");
            cell.style.backgroundColor = row.cells[0].style.backgroundColor;
            checkbox.checked = false;
        }
    }
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

async function fetchUserInfo(_id) {
    const response = await fetch('../pages/api_user.php?' + encodeForAjax({
        id: _id,
    }));
    const faqs = await response.json();
    return faqs;
}