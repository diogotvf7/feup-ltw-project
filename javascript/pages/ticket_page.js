import { fetch_ticket_api, fetch_session_api } from '../api/fetch_api.js'
import { loadAgents, loadDepartmentsSelect, loadStatus } from '../api/load_from_api.js';
import { drawTicketPage } from '../draw_functions/draw_ticket_page.js'
import { setTagsColor, getParameterByName } from '../util.js'

const editButton = document.getElementById('edit-ticket');
const saveButton = document.getElementById('save-ticket');
const cancelEditButton = document.getElementById('cancel-edit-ticket');
const selects = document.querySelectorAll('select');
const tagsSearch = document.getElementById('tags-search');
const tags = document.getElementById('tags');
const addTagButton = document.getElementById('add-tag'); 
const commentForm = document.getElementById('new-comment');

window.onload = async function() { 
    const ticketInfo = await fetch_ticket_api({
        func: 'get_ticket',
        id: getParameterByName('id')
    });
    loadStatus({}, ticketInfo['status']);
    if (ticketInfo['status'] == 'Closed') commentForm.remove();
    drawTicketPage(ticketInfo);
    setTagsColor();

    editButton.addEventListener('click', async function() {
        const session = await fetch_session_api();
        switch (session['permissions']) {
            case 'Agent':
            case 'Admin':
                const departmentId = document.getElementById('department-select').value;
                const agentId = document.getElementById('agent-select').value;
                selects.forEach(select => {
                    if (select.id !== 'status-select') {
                        select.innerHTML = '';
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = '-';
                        select.appendChild(option);
                    }    
                    select.toggleAttribute('disabled');
                });
                tagsSearch.toggleAttribute('hidden');
                addTagButton.toggleAttribute('hidden');
                loadDepartmentsSelect({
                    func: 'departments'
                }, departmentId);
                loadAgents({
                    func: 'getAgents'
                }, agentId);
                makeTagsRemovable();
                if (session['id'] == ticketInfo['clientId']) {
                    const title = document.getElementById('title');
                    const description = document.getElementById('description');
                    title.toggleAttribute('disabled');
                    description.toggleAttribute('disabled');
                    cancelEditButton.toggleAttribute('hidden');
                }
                break;
            case 'Client':
                const title = document.getElementById('title');
                const description = document.getElementById('description');
                title.toggleAttribute('disabled');
                description.toggleAttribute('disabled');
                break;
        }
        cancelEditButton.toggleAttribute('hidden');
        editButton.toggleAttribute('hidden');
        saveButton.toggleAttribute('hidden');
    });
    
    cancelEditButton.addEventListener('click', function() {
        location.reload();
    });
    
    function makeTagsRemovable() {
        const tags = document.querySelectorAll('.tag');
        tags.forEach(tag => { 
            const removeButton = document.createElement('button');
            removeButton.classList.add('remove-tag');
            removeButton.textContent = 'x';
            removeButton.addEventListener('click', function() {
                tag.remove();
            });
            tag.appendChild(removeButton);
        });
    }
    
    addTagButton.addEventListener('click', function() {
        if (tagsSearch.value === '') return;
        if (tags.children.length >= 10) return alert('You can only add 10 tags');
        for (var i = 0; i < tags.children.length; i++)
            if (tags.children[i].textContent.slice(0, -1) == tagsSearch.value)
                return alert('Tag already added');
        const tagInput = document.createElement('input');
        tagInput.type = 'hidden';
        tagInput.name = 'tags[]';
        tagInput.value = tagsSearch.value;
        const tag = document.createElement('p');
        tag.classList.add('tag');
        tag.textContent = tagsSearch.value;
        const removeButton = document.createElement('button');
        removeButton.classList.add('remove-tag');
        removeButton.textContent = 'x';
        removeButton.addEventListener('click', function() {
            tag.remove();
        });
        tag.appendChild(removeButton);
        tag.appendChild(tagInput);
        document.getElementById('tags').appendChild(tag);
        tagsSearch.value = '';
        setTagsColor();
    });
    
}
