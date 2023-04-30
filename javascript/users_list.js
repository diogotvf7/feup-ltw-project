editButton = document.getElementById("edit-button");
saveButton = document.getElementById("save-button");
selectAll = document.getElementById("select-all");
toggleSelect = document.getElementById("toggle-select");
table = document.getElementById("users-list");

editButton.addEventListener("click", function() {
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

saveButton.addEventListener("click", function() {
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