const faqElements = document.querySelectorAll('.faq-element');
const fetchMore = document.querySelector('.fetch-more');

let counter = 1;

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

faqElements.forEach((faqElement, i) => {
    let checkbox = faqElement.children[0];
    let icon = faqElement.children[1].children[0];
    let header = faqElement.children[1].children[1];

    header.textContent = i + 1 + '. ' + header.textContent;

    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    });
});

fetchMore.addEventListener('click', () => {
    fetchFaqs().then((faqs) => {
        if (faqs['result'].length == 0) {
            fetchMore.setAttribute('hidden', 'true');
        } else {
            counter++;
            faqs['result'].forEach((faq) => {
                let faqElement = document.createElement('li');
                faqElement.classList.add('faq-element');
                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = 'cb' + faq.id;
                checkbox.classList.add('faq-element-checkbox');
                let header = document.createElement('label');
                header.classList.add('faq-element-header');
                header.setAttribute('for', checkbox.id);
                let icon = document.createElement('i');
                icon.classList.add('fa-solid');
                icon.classList.add('fa-chevron-down');
                let question = document.createElement('h2');
                question.classList.add('faq-element-question');
                question.textContent = faq.id + '. ' + faq.question;
                let answer = document.createElement('p');
                answer.classList.add('faq-element-answer');
                answer.textContent = faq.answer;
                header.appendChild(icon);
                header.appendChild(question);
                faqElement.appendChild(checkbox);
                faqElement.appendChild(header);
                faqElement.appendChild(answer);
                document.getElementById('faq-list').appendChild(faqElement);
            });
        }
    });
});
    

async function fetchFaqs() {
    const response = await fetch('../pages/api_faq.php?' + encodeForAjax({
        functionname: 'fetchfaqs', 
        n: 10,
        page: counter
    }));
    const faqs = await response.json();
    return faqs;
}