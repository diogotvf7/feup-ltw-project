import { fetch_faq_api, fetch_session_api } from "../api/fetch_api.js";

export async function drawFaq(faq) {
    const session = await fetch_session_api();
    console.log(session.permissions);
    const faqList = document.getElementById('faq-list');

    const faqElement = document.createElement('li'); // Container
    faqElement.classList.add('faq-element');

    const checkbox = document.createElement('input'); // Checkbox for dropdown
    checkbox.type = 'checkbox';
    checkbox.id = 'cb' + faq.id;
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });

    const header = document.createElement('label'); // header
    header.classList.add('faq-element-header');
    header.setAttribute('for', checkbox.id);

    const icon = document.createElement('i'); // Down / up arrow for dropdown
    icon.classList.add('fa-solid');
    icon.classList.add('fa-chevron-down');

    checkbox.classList.add('faq-element-checkbox');

    const index = document.createElement('p'); // Index
    index.classList.add('faq-element-index');
    index.textContent = faq.id + '.';

    const question = document.createElement('p'); // Question
    question.classList.add('faq-element-question');
    question.textContent = faq.question;

    if (session.permissions == 'Admin' || session.permissions == 'Agent') {
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-button');
        const deleteButtonIcon = document.createElement('i');
        deleteButtonIcon.classList.add('fa-solid', 'fa-trash');
        deleteButton.appendChild(deleteButtonIcon);
        deleteButton.addEventListener('click', async (e) => {
            fetch_faq_api({
                'functionname': 'deleteFaq',
                'id': faq.id
            });
            faqElement.remove();
        });
        header.appendChild(deleteButton);
    }

    const answer = document.createElement('p'); // Answer
    answer.classList.add('faq-element-answer');
    answer.textContent = faq.answer;

    header.appendChild(icon);
    header.appendChild(index);
    header.appendChild(question);
    faqElement.appendChild(checkbox);
    faqElement.appendChild(header);
    faqElement.appendChild(answer);
    faqList.appendChild(faqElement);
}

