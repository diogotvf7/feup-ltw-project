// import { fetch_session_api } from '../api/fetch_api.js'
import { timeAgo } from '../util.js'

export async function drawTicketPage(ticket) {
    // const session = await fetch_session_api();
    const _title = document.getElementById('title');
    const _description = document.getElementById('description');
    const _status = document.getElementById('status');
    const _tags = document.getElementById('tags');
    const _department = document.getElementById('department');
    const _author = document.getElementById('author');
    const _agent = document.getElementById('agent');
    const _date = document.getElementById('date');
    const _documentList = document.getElementById('documents-list');
    const _log = document.getElementById('log');

    _title.textContent = ticket['title'];

    _description.textContent = ticket['description'];

    _status.textContent = 'Status: ' + ticket['status'];

    // if (ticket['status'] == 'Open') 
    //     _status.children[0].selected = true;            
    // else if (ticket['status'] == 'Closed') 
    //     _status.children[1].selected = true;
    // else if (ticket['status'] == 'In Progress')
    //     _status.children[2].selected = true;

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