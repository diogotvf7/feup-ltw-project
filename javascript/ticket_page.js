import { fetch_ticket_api } from './api/fetch_api.js'
import { drawTicketPage } from './draw_functions/draw_ticket_page.js'
import { setTagsColor, getParameterByName } from './util.js'

window.onload = async function() { 
    const ticketInfo = await fetch_ticket_api({
        func: 'get_ticket',
        id: getParameterByName('id')
    });
    drawTicketPage(ticketInfo);
    setTagsColor();
}
