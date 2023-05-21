import { fetch_session_api, fetch_ticket_api } from '../api/fetch_api.js'
import { loadDepartments, loadTags } from '../api/load_from_api.js'
import { drawTicketPreview } from '../draw_functions/draw_ticket_preview.js'
import { setTagsColor } from '../util.js'

window.onload = async function() {
    const session = await fetch_session_api();
    loadDepartments({
        func: 'departments'
    });
    loadTags({
        func: 'tags'
    });
    const tickets = await fetch_ticket_api({
        func: 'display_tickets',
        sort: 'DESC'
    }); 
    for (const ticket of tickets['tickets'])
        drawTicketPreview(ticket, session);
    setTagsColor();

    filterForm.addEventListener('submit', async function (event) {
        const list = document.getElementById('ticket-list');
        event.preventDefault();
        const formData = new FormData(filterForm);
        let tickets = await fetch_ticket_api({
            func: 'display_tickets',
            dateLowerBound: formData.get('dateLowerBound'),
            dateUpperBound: formData.get('dateUpperBound'),
            status: formData.get('status'),
            departments: formData.get('department'),
            tags: formData.getAll('tag'),
            sort: formData.get('sort')
        });
        list.innerHTML = '';
        if (tickets['tickets'].length === 0) {
            const noTickets = document.createElement('div');
            noTickets.classList.add('noTickets');
            const image = document.createElement('img');
            image.src = '../docs/panda.jpg';
            image.classList.add('panda');
            const textPostPanda = document.createElement('h2');
            textPostPanda.textContent = 'No tickets yet, just a panda eating bamboo';
            textPostPanda.classList.add('text-post-panda');
            noTickets.appendChild(image);
            noTickets.appendChild(textPostPanda);
            list.appendChild(noTickets);
        }
        for (const ticket of tickets['tickets'])
            drawTicketPreview(ticket, session);
        setTagsColor();
    });   
}

const filterForm = document.getElementById('filter-form');    