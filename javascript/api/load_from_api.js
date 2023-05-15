import { fetch_department_api, fetch_tag_api } from './fetch_api.js'

export async function loadDepartments(params) {
    const departmentsSelect = document.getElementById('department-select');
    const departments = await fetch_department_api(params);
    if (departments.length !== 0) {
        for (const department of departments) {
            const option = document.createElement('option');
            option.value = department.DepartmentID;
            option.textContent = department.Name;
            departmentsSelect.appendChild(option);
        }
    } else {
        document.querySelector('#filter-form > label[for="department-select"]').hidden = true;
        departmentsSelect.hidden = true;
    }
}

export async function loadTags(_page) {
    const tagsSelect = document.getElementById('tag-select');
    const tags = await fetch_tag_api(_page);
    if (tags.length !== 0) {
        for (const tag of tags) {
            const option = document.createElement('option');
            option.value = tag.TagID;
            option.textContent = tag.Name;
            tagsSelect.appendChild(option);
        }
    } else {
        tagsSelect.hidden = true;
        document.querySelector('#filter-form > label[for="tag-select"]').hidden = true;
    }
}