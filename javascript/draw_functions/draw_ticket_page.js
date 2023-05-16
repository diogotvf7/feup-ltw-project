// import { fetch_session_api } from '../api/fetch_api.js'
import { timeAgo } from '../util.js'
import { autocomplete } from '../misc/autocomplete.js'
import { fetch_tag_api } from '../api/fetch_api.js';

export async function drawTicketPage(ticket) {
    // const session = await fetch_session_api();
    const _form = document.getElementById('ticket-form');
    const _title = document.getElementById('title');
    const _description = document.getElementById('description');
    const _status = document.getElementById('status');
    const _tags = document.getElementById('tags');
    const _department = document.getElementById('department-select');
    const _author = document.getElementById('author');
    const _agent = document.getElementById('agent-select');
    const _date = document.getElementById('date');
    const _documentList = document.getElementById('documents-list');
    const _log = document.getElementById('log');

    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = ticket['id'];
    _form.appendChild(idInput);

    _title.value = ticket['title'];

    _description.textContent = ticket['description'];

    if (ticket['status'] == 'Open') 
        _status.children[0].selected = true;            
    else if (ticket['status'] == 'Closed') 
        _status.children[1].selected = true;
    else if (ticket['status'] == 'In Progress')
        _status.children[2].selected = true;

    if (ticket['departmentId'] != null) {
        const option = document.createElement('option');
        option.selected = true;
        option.value = ticket['departmentId'];
        option.textContent = ticket['departmentName'];
        _department.appendChild(option);
    } else {
        const option = document.createElement('option');
        option.selected = true;
        option.textContent = 'No department associated';
        _department.appendChild(option);
    }
    
    _author.textContent = 'By: @' + ticket['author'];

    if (ticket['agentId'] != null) {
        const option = document.createElement('option');
        option.selected = true;
        option.value = ticket['agentId'];
        option.textContent = '@' + ticket['agentName'];
        _agent.appendChild(option);
    } else {
        const option = document.createElement('option');
        option.selected = true;
        option.textContent = 'No agent assigned';
        _agent.appendChild(option);
    }

    _date.textContent = 'Created ' + timeAgo(ticket['date']['date']);

    for (const tag of ticket['tags']) {
        const tagInput = document.createElement('input');
        tagInput.type = 'hidden';
        tagInput.name = 'tags[]';
        tagInput.value = tag;
        const tagElement = document.createElement('p');
        tagElement.textContent = tag;
        tagElement.classList.add('tag');
        tagElement.appendChild(tagInput);
        _tags.appendChild(tagElement);
    }

    autocomplete(
        document.getElementById("tags-search"), 
        await fetch_tag_api({ 
            func: 'tags'
        }).then(tags => tags.map(tag => tag['Name'])),
    );
    
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