import { loadDepartmentsTable, loadMostUsedTags, loadTicketsStats } from "../api/load_from_api.js"
import { createAddDepartmentForm, createAddStatusForm } from "../draw_functions/admin_page.js"

const dropButton = document.getElementById('create-button');
const dropContent = document.getElementById('drop-content');
const createDepartmentButton = document.getElementById('create-department');
const createStatusButton = document.getElementById('create-status');
const createFaqButton = document.getElementById('create-faq');

window.onload = async function() {
    loadDepartmentsTable({func: 'departments'});
    loadMostUsedTags({func: 'getMostUsedTags'});
    loadTicketsStats({func: 'getTicketsStats'});

    dropButton.addEventListener('click', () => {
        dropContent.toggleAttribute('hidden');
    });

    createDepartmentButton.addEventListener('click', async () => {
        const main = document.querySelector('main');
        const form = await createAddDepartmentForm();
        main.appendChild(form);
    });

    createStatusButton.addEventListener('click', async () => {
        const main = document.querySelector('main');
        const form = await createAddStatusForm();
        main.appendChild(form);
    });

    createFaqButton.addEventListener('click', function() {
        window.location.href = 'new_faq.php';
    });
}
