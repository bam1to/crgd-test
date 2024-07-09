export default class FormTransformer {
    transformToEditForm(newsId) {
        const updateForm = document.querySelector('#create-news');
        updateForm.action = '/news/update';
        updateForm.dataset.role = 'edit';

        const formHeader = updateForm.querySelector('[data-role="form-header"]');
        formHeader.textContent = 'Edit News';

        const formSubmitButton = updateForm.querySelector('[data-role="form-submit"]');
        formSubmitButton.textContent = 'Save';

        const newsRow = document.querySelector(`[data-news-id="${newsId}"]`);

        const newsRowTitle = newsRow.querySelector('.info-row-title').innerText,
            newsRowDescription = newsRow.querySelector('.info-row-description').innerText;

        updateForm.querySelector('#news-title').value = newsRowTitle;
        updateForm.querySelector('#news-description').value = newsRowDescription;
        updateForm.querySelector('#news-id').value = newsId;

        if (!updateForm.querySelector('[data-action="close"]')) {
            formHeader.insertAdjacentHTML('afterend', this.#getCloseButton());
        }
    }

    #getCloseButton() {
        return `
        <button type="button" class="i-btn" data-action="close">
            <i class="i-btn-close"></i>
        </button>`;
    }

    transformToCreateForm() {
        const createForm = document.querySelector('#create-news');
        createForm.action = '/news/create';
        createForm.dataset.role = 'create';

        const formHeader = createForm.querySelector('[data-role="form-header"]');
        formHeader.textContent = 'Create News';

        const formSubmitButton = createForm.querySelector('[data-role="form-submit"]');
        formSubmitButton.textContent = 'Create';

        createForm.querySelector('#news-id').value = '0';

        createForm.querySelector('[data-action="close"]').remove();

        createForm.reset();
    }
}