import { drawFaq } from "../draw_functions/draw_faq.js";
import { fetch_faq_api } from "../api/fetch_api.js";

const faqElements = document.querySelectorAll('.faq-element');
const fetchMore = document.querySelector('.fetch-more');

let counter = 0;

window.onload = async function() {
    let faqs = await fetch_faq_api({
        functionname: 'fetchfaqs', 
        n: 10, 
        page: counter
    });
    if (faqs['result'].length == 0) {
        fetchMore.setAttribute('hidden', 'true');
    } else {
        counter++;
        faqs['result'].forEach((faq) => drawFaq(faq));
    }
}

fetchMore.addEventListener('click', async () => {
    let faqs = await fetch_faq_api({
        functionname: 'fetchfaqs', 
        n: 10, 
        page: counter
    });

    if (faqs['result'].length == 0) {
            fetchMore.setAttribute('hidden', 'true');
    } else {
        counter++;
        faqs['result'].forEach((faq) => drawFaq(faq));
    }
});
    