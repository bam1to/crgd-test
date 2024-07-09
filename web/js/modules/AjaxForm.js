import NewsDto from "../dto/ NewsDto.js";
import FormTransformer from "./FormTransformer.js";
import Message from "./Message.js";
import NewsRow from "./NewsRow.js";

export default class AjaxForm {
    #form = null;

    constructor(formSelector) {
        this.#form = document.querySelector(formSelector);
        this.#bindEvents();
    }

    #bindEvents() {
        if (this.#form) {
            this.#form.addEventListener('submit', (event) => this.#handleEvent(event));
        }
    }

    async #handleEvent(event) {
        event.preventDefault();
        const formData = new FormData(this.#form);
        const url = this.#form.action;
        const method = this.#form.method;

        try {
            const response = await fetch(url, {
                method: method,
                body: formData
            });

            if (response.ok) {
                const result = await response.json();
                this.handleSuccess(result);
            } else {
                this.handleError(response);
            }
        } catch (error) {
            this.handleError(error);
        }

        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }

    handleSuccess(data) {
        let message = new Message('.message', { messageText: '', messageType: 'success' });
        switch (this.#form.dataset.role) {
            case 'edit': {
                message.messageParams.messageText = 'News was successfully updated';
                this.#updateNews(data);
                break;
            }
            case 'create': {
                message.messageParams.messageText = 'News was successfully created';
                this.#createNews(data);
                break
            }
        }
        message.createMessage();
        this.#form.reset();

    }

    #updateNews() {
        let newsRow = new NewsRow();
        newsRow.update(data)
        let formTransformer = new FormTransformer();
        formTransformer.transformToCreateForm();
    }

    #createNews(data) {
        const newsRow = new NewsRow();
        newsRow.create(new NewsDto(data.newsId, data.title, data.description));
    }

    handleError(error) {
        let message = new Message('.message', { messageText: error.statusText, messageType: 'error' });
        message.createMessage();
    }
}