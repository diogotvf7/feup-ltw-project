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
