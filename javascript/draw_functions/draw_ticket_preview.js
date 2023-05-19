import { timeAgo, limitDisplayLength, sleep } from '../util.js'
import { fetch_ticket_api } from '../api/fetch_api.js'

export async function drawTicketPreview(ticket, session) {
    const list = document.getElementById('ticket-list');

    const ticketPreview = document.createElement('a'); // ticket preview
    ticketPreview.classList.add('ticket-list-element');
    ticketPreview.href = `ticket_page.php?id=${ticket.id}`;    

    const topDiv = document.createElement('div'); // top div
    topDiv.classList.add('space-between');

    const title = document.createElement('h3'); // title
    title.textContent = ticket.title;
    title.classList.add('title');
    topDiv.appendChild(title);

    const status = document.createElement('p'); // status
    status.textContent = ticket.status;
    status.classList.add('status');
    topDiv.appendChild(status);

    const time = document.createElement('p'); // time
    time.textContent = timeAgo(ticket.date.date);
    time.classList.add('time');
    topDiv.appendChild(time);
    
    if (session.id == ticket.clientId || session.permissions == 'Admin' || session.permissions == 'Agent') {
        const deleteButton = document.createElement('button'); // delete button
        deleteButton.classList.add('delete-button');
        const deleteButtonIcon = document.createElement('i');
        deleteButtonIcon.classList.add('fa-solid', 'fa-trash');
        deleteButton.appendChild(deleteButtonIcon);
        deleteButton.addEventListener('click', async (e) => {
            e.preventDefault();
            fetch_ticket_api({
                'func': 'delete_ticket', 
                'id': ticket.id
            });
            ticketPreview.style.transform = 'translate(200%, 0)';
            await sleep(300);
            ticketPreview.remove();  
        });    
        topDiv.appendChild(deleteButton);
    }

    ticketPreview.appendChild(topDiv);


    const description = document.createElement('p'); // description
    description.textContent = limitDisplayLength(ticket.description, 170);
    description.classList.add('description');

    ticketPreview.appendChild(description);


    const bottomDiv = document.createElement('div'); // bottom div
    bottomDiv.classList.add('space-between');

    for (let i = 0; i < 3 && i < ticket.tags.length; i++) {
        const tagElement = document.createElement('p');
        tagElement.textContent = ticket.tags[i];
        tagElement.classList.add('tag');
        bottomDiv.appendChild(tagElement);
    }

    const author = document.createElement('p'); // author
    author.textContent = 'Author: ' + (ticket.author != '' ? '@' + ticket.author : 'User removed');
    author.classList.add('author');
    bottomDiv.appendChild(author);

    const agent = document.createElement('p'); // agent
    agent.textContent = 'Agent: ' + (ticket.assignee != '' ? '@' + ticket.assignee : 'Unassigned');
    agent.classList.add('agent');
    bottomDiv.appendChild(agent);

    const department = document.createElement('p'); // department
    department.textContent = ticket.departmentName;
    department.classList.add('department');
    bottomDiv.appendChild(department);

    ticketPreview.appendChild(bottomDiv);

    list.appendChild(ticketPreview);

}
