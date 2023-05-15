// Script to input ticket previews in ticket-list

const list = document.getElementById('ticket-list');
currentPage = window.location.href.split('/').pop();

const pattern = /\/pages\/([a-z_]+)\.php/;
const match = pattern.exec(window.location.href);

switch (match[1]) {
    case 'display_tickets': case 'my_tickets':
        window.onload = async function() {
            loadDepartments(match[1]);
            loadTags(match[1]);
            const response = await fetch('../pages/api_ticket.php?' + encodeForAjax({
                func: currentPage.substring(0, currentPage.length - 4),
                sort: 'DESC'
            }));
            const tickets = await response.json();  
            for (const ticket of tickets['tickets'])
                drawTicketPreview(ticket);
            setTagsColor();
        }
        const filterForm = document.getElementById('filter-form');    
        filterForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const formData = new FormData(filterForm);
            console.log(formData);
            tickets = await fetchTickets(
                formData.get('dateLowerBound'),
                formData.get('dateUpperBound'),
                formData.get('status'),
                formData.get('department'),
                formData.getAll('tag'),
                formData.get('sort')
            );
            list.innerHTML = '';
            for (const ticket of tickets['tickets'])
                drawTicketPreview(ticket);
        });   
        break;

    case 'ticket_page':
        window.onload = async function() { 
            const response = await fetch('../pages/api_ticket.php?' + encodeForAjax({
                func: 'get_ticket',
                id: getParameterByName('id')
            }));
            const ticketInfo = await response.json();
            drawTicketPage(ticketInfo);
            setTagsColor();
        }
        break;

    default:
        console.log('This page isn\'t recognized: ' + match);
        break;
}

async function drawTicketPage(ticket) {
    const session = await getSession();
    _title = document.getElementById('title');
    _description = document.getElementById('description');
    _status = document.getElementById('status');
    _tags = document.getElementById('tags');
    _department = document.getElementById('department');
    _author = document.getElementById('author');
    _agent = document.getElementById('agent');
    _date = document.getElementById('date');
    _documentList = document.getElementById('documents-list');
    _log = document.getElementById('log');

    _title.textContent = ticket['title'];

    _description.textContent = ticket['description'];

    if (session['permissions'] == 'Admin' || session['permissions'] == 'Agent') {
        if (ticket['status'] == 'Open') 
            _status.children[0].selected = true;            
        else if (ticket['status'] == 'Closed') 
            _status.children[1].selected = true;
        else if (ticket['status'] == 'In Progress')
            _status.children[2].selected = true;
    } else {
        _status.textContent = ticket['status']; 
    }

    if (ticket['departmentId'] == null)
        _department.textContent = 'No department assigned';
    else 
        _department.textContent = 'Department: ' + ticket['departmentName'];

    _author.textContent = 'By: @' + ticket['author'];
    
    if (ticket['agentId'] == null)
        _agent.textContent = 'No agent assigned';
    else
        _agent.textContent = 'Currently assigned to: @' + ticket['agentName'];

    _date.textContent = 'Created ' + timeAgo(ticket['date']['date']);

    if (ticket['tags'].length == 0) 
        _tags.remove();
    else
        for (const tag of ticket['tags']) {
            const tagElement = document.createElement('p');
            tagElement.textContent = tag;
            tagElement.classList.add('tag');
            _tags.appendChild(tagElement);
        }

    if (ticket['documents'].length == 0) 
        _documentList.remove();
    else
        for (const doc of ticket['documents']) {
            const docListElement = document.createElement('img');
            docListElement.src = '../' + doc;
            docListElement.classList.add('document');
            _documentList.appendChild(docListElement);
        }
    
    let i = 0, j = 0;
    while (i < ticket['updates'].length || j < ticket['comments'].length) {
        
        if (i == ticket['updates'].length)
            _log.appendChild(createCommentElement(ticket['comments'][j++]));
        
        else if (j == ticket['comments'].length)
            _log.appendChild(createUpdateElement(ticket['updates'][i++]));
        
        else if (ticket['comments'][j]['Date'] > ticket['updates'][i]['Date'])
            _log.appendChild(createUpdateElement(ticket['updates'][i++]));
        
        else
            _log.appendChild(createCommentElement(ticket['comments'][j++]));
    }
}

function createCommentElement(commentInfo) {
    const comment = document.createElement('div');
    comment.classList.add('comment');
    
    const body = document.createElement('p');
    body.classList.add('comment-body');
    body.textContent = commentInfo['Comment'];

    const bottom = document.createElement('div');
    bottom.classList.add('comment-bottom');

    const author = document.createElement('p');
    author.classList.add('comment-author');
    author.textContent = '@' + commentInfo['Username'];

    const date = document.createElement('p');
    date.classList.add('comment-date');
    date.textContent = timeAgo(commentInfo['Date']);

    bottom.appendChild(author);
    bottom.appendChild(date);
    comment.appendChild(body);
    comment.appendChild(bottom);
    return comment;
}

function createUpdateElement(updateInfo) {
    const update = document.createElement('div');
    update.classList.add('update');

    const body = document.createElement('p');
    body.classList.add('update-body');
    body.textContent = updateInfo['Message'];

    const date = document.createElement('p');
    date.classList.add('update-date');
    date.textContent = timeAgo(updateInfo['Date']);

    update.appendChild(body);
    update.appendChild(date);
    return update;
}

function drawTicketPreview(ticket) {
    const ticketPreview = document.createElement('a'); // ticket preview
    ticketPreview.classList.add('ticket-list-element');
    ticketPreview.href = 'ticket_page.php?' + encodeForAjax({
        id: ticket.id
    });
    const title = document.createElement('h3'); // title
    title.textContent = ticket.title;
    title.classList.add('title');
    const time = document.createElement('p'); // time
    time.textContent = timeAgo(ticket.date.date);
    time.classList.add('time');
    const description = document.createElement('p'); // description
    description.textContent = limitDisplayLength(ticket.description, 60);
    description.classList.add('description');
    const tagsDiv = document.createElement('div'); // tags div
    tagsDiv.classList.add('tags');
    const status = document.createElement('p'); // status
    status.textContent = ticket.status;
    status.classList.add('status');
    tagsDiv.appendChild(status);
    for (const tag of ticket.tags) {
        const tagElement = document.createElement('p');
        tagElement.textContent = tag;
        tagElement.classList.add('tag');
        tagsDiv.appendChild(tagElement);
    }
    const author = document.createElement('p'); // author
    author.textContent = '@' + ticket.author;
    author.classList.add('author');


    ticketPreview.appendChild(title);
    ticketPreview.appendChild(time);
    ticketPreview.appendChild(description);
    ticketPreview.appendChild(tagsDiv);
    ticketPreview.appendChild(author);

    list.appendChild(ticketPreview);

    // const department = document.createElement('p'); // department
}

async function loadDepartments(_page) {
    const departmentsSelect = document.getElementById('department-select');
    const departments = await fetchDepartments(_page);
    if (departments.length !== 0) {
        for (const department of departments) {
            const option = document.createElement('option');
            option.value = department.DepartmentID;
            option.textContent = department.Name;
            departmentsSelect.appendChild(option);
        }
    } else {
        document.querySelector('#filter-form > label[for="department-select"]').hidden = true;
        departmentsSelect.hidden = true;
    }
}

async function loadTags(_page) {
    const tagsSelect = document.getElementById('tag-select');
    const tags = await fetchTags(_page);
    if (tags.length !== 0) {
        for (const tag of tags) {
            const option = document.createElement('option');
            option.value = tag.TagID;
            option.textContent = tag.Name;
            tagsSelect.appendChild(option);
        }
    } else {
        tagsSelect.hidden = true;
        document.querySelector('#filter-form > label[for="tag-select"]').hidden = true;
    }
}

async function getSession() {
    const response = await fetch('../pages/api_session.php');
    const session = await response.json();
    return session;
}

async function fetchTags(_page) {
    const response = await fetch('../pages/api_tag.php?' + encodeForAjax({
        func: _page == 'display_tickets' ? 'tags' : 'user_tags',
    }));
    const tags = await response.json();
    return tags;
}

async function fetchDepartments(_page) {
    const response = await fetch('../pages/api_department.php?' + encodeForAjax({
        func: _page == 'display_tickets' ? 'departments' : 'user_departments',
    }));
    const departments = await response.json();
    return departments;
}

async function fetchTickets(_dateLowerBound, _dateUpperBound, _status, _departments, _tags, _sort) {
    const response = await fetch('../pages/api_ticket.php?' + encodeForAjax({
        func: currentPage.substring(0, currentPage.length - 4),
        dateLowerBound: _dateLowerBound,
        dateUpperBound: _dateUpperBound,
        status: _status ? _status : null,
        departments: _departments != '' ? _departments : null,
        tags: _tags != '' ? _tags : null,
        sort: _sort != '' ? _sort : null
    }));
    const tickets = await response.json();
    return tickets;
}

// Script to assign colors to tags 

async function setTagsColor() {
    const tags = document.querySelectorAll('.tag');
    var index = 0;
    const tagColors = [ "#FFD700", // gold 
                        "#00CED1", // dark turquoise 
                        "#7B68EE", // medium slate blue 
                        "#FF69B4", // hot pink 
                        "#FFA07A", // light salmon 
                        "#8B008B", // dark magenta 
                        "#00FA9A", // medium spring green 
                        "#1E90FF"  // dodger blue
                    ];    
    const tagColorMap = new Map();
    tags.forEach(tag => {
        var colorAssigned = tagColorMap.get(tag.textContent);
        if (colorAssigned != undefined)
            tag.style.backgroundColor = colorAssigned;
        else {
            tag.style.backgroundColor = tagColors[index];
            tagColorMap.set(tag.textContent, tagColors[index]);
            index = (index + 1) % tagColors.length;
        }
    });
    
    const statuses = document.querySelectorAll('.status');
    statuses.forEach(status => {
        if (status.textContent.trim() == "Open")
            status.style.backgroundColor = "#32CD32";
        else if (status.textContent.trim() == "Closed")
            status.style.backgroundColor = "#FF6347";
        else if (status.textContent.trim() == "In progress")
            status.style.backgroundColor = "#FFD700";
    });

    const _status = document.getElementById('status');

    if (_status) {
        const session = await getSession();         
        if (session['permissions'] == ['Admin'] || session['permissions'] == ['Agent']) {   
            const option = _status.options[_status.selectedIndex].value;
            if (option == "Open") _status.style.color = "#32CD32";
            else if (option == "Closed") _status.style.color = "#FF6347";
            else if (option == "In progress") _status.style.color = "#FFD700";
            _status.addEventListener('change', function() {
                const option = _status.options[_status.selectedIndex].value;
                if (option == "Open") _status.style.color = "#32CD32";
                else if (option == "Closed") _status.style.color = "#FF6347";
                else if (option == "In progress") _status.style.color = "#FFD700";
            });
        } else {
            const statusValue = _status.textContent;
            if (statusValue.trim() == "Open") _status.style.border = "1px solid #32CD32";
            else if (statusValue.trim() == "Closed") _status.style.border = "1px solid #FF6347";
            else if (statusValue.trim() == "In progress") _status.style.border = "1px solid #FFD700";
        }
    }
}

// Script to display the date in a human readable format

function timeAgo(_date) {
    const date = new Date(_date); 
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);

    if (diff < 60) {
      return 'just now';
    } else if (diff < 3600) {
      const minutes = Math.floor(diff / 60);
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    } else if (diff < 86400) {
      const hours = Math.floor(diff / 3600);
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    } else if (diff < 2592000) {
      const days = Math.floor(diff / 86400);
      return `${days} day${days > 1 ? 's' : ''} ago`;
    } else if (diff < 31536000) {
      const months = Math.floor(diff / 2592000);
      return `${months} month${months > 1 ? 's' : ''} ago`;
    } else {
      const years = Math.floor(diff / 31536000);
      return `${years} year${years > 1 ? 's' : ''} ago`;
    }
}

// Script to remove overflow from strings

function limitDisplayLength(string, maxSize) {
    if (string.length > maxSize) 
        return string.substr(0, maxSize - 3) + '...';
    return string;
}

// Script to encode data for ajax

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        if (data[k] === null || data[k] === undefined) return;
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

// Script to get url parameter by name

function getParameterByName(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}