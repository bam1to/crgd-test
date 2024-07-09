import AjaxForm from "./modules/AjaxForm.js";
import AjaxNewsDelete from "./modules/AjaxNewsDelete.js";
import FormTransformer from "./modules/FormTransformer.js";

class Main {
    constructor() {
        this.initForms();
        this.initEventListeners();
    }

    initForms() {
        new AjaxForm('#create-news');
    }

    initEventListeners() {
        document.addEventListener('click', (event) => {
            if (event?.target.closest('.i-btn[data-action="delete"]')) {
                const newsId = event.target.closest('[data-news-id]').dataset.newsId;
                new AjaxNewsDelete(newsId);
            }

            if (event?.target.closest('.i-btn[data-action="edit"]')) {
                const newsId = event.target.closest('[data-news-id]').dataset.newsId
                const formTransformer = new FormTransformer();
                formTransformer.transformToEditForm(newsId);
            }

            if (event?.target.closest('.i-btn[data-action="close"]')) {
                const formTransformer = new FormTransformer();
                formTransformer.transformToCreateForm();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const main = new Main();
});