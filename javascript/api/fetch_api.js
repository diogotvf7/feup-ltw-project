export async function fetch_session_api() {
    const response = await fetch('../pages/api_session.php');
    const session = await response.json();
    return session;
}

export async function fetch_user_api(params) {
    const response = await fetch('../pages/api_user.php?' + encodeForAjax(params));
    const users = await response.json();
    return users;
}

export async function fetch_tag_api(params) {
    const response = await fetch('../pages/api_tag.php?' + encodeForAjax(params));
    const tags = await response.json();
    return tags;
}

export async function fetch_department_api(params) {
    const response = await fetch('../pages/api_department.php?' + encodeForAjax(params));
    const departments = await response.json();
    return departments;
}

export async function fetch_ticket_api(params) {
    const response = await fetch('../pages/api_ticket.php?' + encodeForAjax(params));
    const tickets = await response.json();
    return tickets;
}

export async function fetch_faq_api(params) {
    const response = await fetch('../pages/api_faq.php?' + encodeForAjax(params));
    const faqs = await response.json();
    return faqs;
}

export async function fetch_status_api(method, params) {
    let response;
    switch (method) {
        case 'GET':
            response = await fetch('../pages/api_status.php?' + encodeForAjax(params));
            break;
        default:
            response = await fetch('../pages/api_status.php?', {
                method: method,
                headers: {
                  'Content-Type': 'application/json'
                },
                body: encodeForAjax(params)
            })
    }
    return await response.json();
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        if (data[k] === null || data[k] === undefined) return;
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}