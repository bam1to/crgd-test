import AjaxForm from "./modules/AjaxForm.js";
import AjaxNewsDelete from "./modules/AjaxNewsDelete.js";

class Main {
    constructor() {
        this.initForms();
        this.initEventListeners();
    }

    initForms() {
        new AjaxForm('#create-news');
    }

    initEventListeners() {
        document.querySelector('#news-container').addEventListener('click', (event) => {
            if (event?.target.closest('.i-btn[data-action="delete"]')) {
                const newsId = event.target.closest('[data-news-id]').dataset.newsId;
                new AjaxNewsDelete(newsId);
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const main = new Main();
});