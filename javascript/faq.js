const faqElements = document.querySelectorAll('.faq-element');

faqElements.forEach(faqElement => {
    faqElement.addEventListener('click', () => {
        let text = faqElement.childNodes[2];
        console.log(text);
        text.toggleAttribute('hidden');
    });
});



