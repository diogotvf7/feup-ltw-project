import { fetch_ticket_api } from '../api/fetch_api.js'
import { loadDepartments, loadTags } from '../api/load_from_api.js'
import { drawTicketPreview } from '../draw_functions/draw_ticket_preview.js'
import { setTagsColor } from '../util.js'

const list = document.getElementById('ticket-list');

window.onload = async function() {
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
        drawTicketPreview(ticket);
    setTagsColor();
}

const filterForm = document.getElementById('filter-form');    

filterForm.addEventListener('submit', async function (event) {
    event.preventDefault();
    const formData = new FormData(filterForm);
    console.log(formData);
    tickets = await fetch_ticket_api({
        func: 'display_tickets',
        dateLowerBound: formData.get('dateLowerBound'),
        dateUpperBound: formData.get('dateUpperBound'),
        status: formData.get('status'),
        departments: formData.get('department'),
        tags: formData.getAll('tag'),
        sort: formData.get('sort')
    });
    list.innerHTML = '';
    for (const ticket of tickets['tickets'])
        drawTicketPreview(ticket);
});   
