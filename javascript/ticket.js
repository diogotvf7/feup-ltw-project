// Script to input ticket previews in ticket-list

const list = document.getElementById('ticket-list');
currentPage = window.location.href.split('/').pop();

const pattern = /\/pages\/([a-z_]+)\.php/;
const match = pattern.exec(window.location.href);

switch (match[1]) {
    case 'display_tickets': case 'my_tickets':
        window.onload = async function() {
            loadDepartments();
            loadTags();
            const response = await fetch('../pages/api_ticket.php?' + encodeForAjax({
                func: currentPage.substring(0, currentPage.length - 4),
                sort: 'DESC'
            }));
            const tickets = await response.json();
            if (tickets['tickets'].length === 0) {
                const noTickets = document.createElement('div');
                noTickets.classList.add('noTickets');
                const image = document.createElement('img');
                image.src = '../docs/panda.jpg';
                image.classList.add('panda');
                const textPostPanda = document.createElement('h2');
                textPostPanda.textContent = 'No tickets yet, just a panda eating bamboo.';
                textPostPanda.classList.add('text-post-panda');
                noTickets.appendChild(image);
                noTickets.appendChild(textPostPanda);
                list.appendChild(noTickets);
            }
            else {    
                for (const ticket of tickets['tickets']) createTicketPreview(ticket);
                setTagsColor();
            }                
        }
        const filterForm = document.getElementById('filter-form');    
        filterForm.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(filterForm);
            tickets = await fetchTickets(
                formData.get('dateLowerBound'),
                formData.get('dateUpperBound'),
                formData.get('status'),
                formData.get('department'),
                formData.getAll('tag'),
                formData.get('sort')
            );
            list.innerHTML = '';
            if (tickets['tickets'].length === 0) {
                const noTickets = document.createElement('div');
                noTickets.classList.add('noTickets');
                const image = document.createElement('img');
                image.src = '../docs/panda.jpg';
                image.classList.add('panda');
                const textPostPanda = document.createElement('h2');
                textPostPanda.textContent = 'No tickets yet, just a panda eating bamboo.';
                textPostPanda.classList.add('text-post-panda');
                noTickets.appendChild(image);
                noTickets.appendChild(textPostPanda);
                list.appendChild(noTickets);
            }
            for (const ticket of tickets['tickets'])
                createTicketPreview(ticket);
            setTagsColor();
        });
        break;

    case 'ticket_page':
        setTagsColor();
        break;

    case 'new_ticket':  
        var file_input = document.getElementById('submitted-files');
        var allowed_extensions = ['.png', '.jpg', '.jpeg', '.gif'];
        if (file_input)
            file_input.addEventListener('change', function() {
                var files = file_input.files;
        
                for (var i = 0; i < files.length; i++) {
                    var file_name = files[i].name;
                    var file_extension = file_name.substring(file_name.lastIndexOf('.'));
        
                    if (!allowed_extensions.includes(file_extension.toLowerCase())) {
                        // The uploaded file has an invalid extension, so display an error message
                        alert('Error: Invalid file type.');
                        file_input.value = '';
                        return;
                    }
                }
        
                // All uploaded files have valid extensions, so proceed with the submission
            });
        break;
    default:
        console.log('This page isn\'t recognized: ' + match);
        break;
}

function createTicketPreview(ticket) {
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

async function loadDepartments() {
    const departmentsSelect = document.getElementById('department-select');
    const departments = await fetchDepartments();
    if (departments.length !== 0) {
        for (const department of departments) {
            const option = document.createElement('option');
            option.value = department.DepartmentID;
            option.textContent = department.Name;
            departmentsSelect.appendChild(option);
        }
    }
}

async function loadTags() {
    const tagsSelect = document.getElementById('tag-select');
    const tags = await fetchTags();
    if (tags.length !== 0) {
        for (const tag of tags) {
            const option = document.createElement('option');
            option.value = tag.TagID;
            option.textContent = tag.Name;
            tagsSelect.appendChild(option);
        }
}
}

async function fetchTags() {
    const response = await fetch('../pages/api_tag.php?' + encodeForAjax({
        func: 'tags',
    }));
    const tags = await response.json();
    return tags;
}

async function fetchDepartments() {
    const response = await fetch('../pages/api_department.php?' + encodeForAjax({
        func: 'departments',
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

function setTagsColor() {
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
    });
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