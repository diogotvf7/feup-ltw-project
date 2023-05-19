import { timeAgo, limitDisplayLength } from '../util.js'

export function drawTicketPreview(ticket) {
    const list = document.getElementById('ticket-list');
    
    const ticketPreview = document.createElement('a'); // ticket preview
    ticketPreview.classList.add('ticket-list-element');
    ticketPreview.href = `ticket_page.php?id=${ticket.id}`;
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
    for (let i = 0; i < 3 && i < ticket.tags.length; i++) {
        const tagElement = document.createElement('p');
        tagElement.textContent = ticket.tags[i];
        tagElement.classList.add('tag');
        tagsDiv.appendChild(tagElement);
    }
    const author = document.createElement('p'); // author
    author.textContent = ticket.author != '' ? '@' + ticket.author : 'User removed';
    author.classList.add('author');
    const agent = document.createElement('p'); // agent
    agent.textContent = ticket.assignee != '' ? '@' + ticket.assignee : 'Unassigned';
    agent.classList.add('agent');
    const department = document.createElement('p'); // department
    department.textContent = ticket.departmentName;
    department.classList.add('department');

    const bottomDiv = document.createElement('div'); // bottom div
    bottomDiv.classList.add('space-between');
    bottomDiv.appendChild(tagsDiv);
    bottomDiv.appendChild(author);
    bottomDiv.appendChild(agent);
    bottomDiv.appendChild(department);

    ticketPreview.appendChild(title);
    ticketPreview.appendChild(time);
    ticketPreview.appendChild(description);
    ticketPreview.appendChild(bottomDiv);
    // ticketPreview.appendChild(tagsDiv);
    // ticketPreview.appendChild(author);
    // ticketPreview.appendChild(agent);
    // ticketPreview.appendChild(department);

    list.appendChild(ticketPreview);

}
