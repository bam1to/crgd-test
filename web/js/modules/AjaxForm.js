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
        console.log('Form submitted successfully:', data);
        switch (this.#form.dataset.role) {
            case 'edit': {
                let message = new Message('.message', { messageText: 'News was successfully updated', messageType: 'success' });
                message.createMessage();
                let newsRow = new NewsRow();
                newsRow.update(data)
                let formTransformer = new FormTransformer();
                formTransformer.transformToCreateForm();
                break;
            }
            case 'create': {
                let message = new Message('.message', { messageText: 'News was successfully created', messageType: 'success' });
                message.createMessage();
                let newsRow = new NewsRow();
                newsRow.create(new NewsDto(data.newsId, data.title, data.description));
                break
            }
        }
        this.#form.reset();

    }

    handleError(error) {
        let message = new Message('.message', { messageText: error.statusText, messageType: 'error' });
        message.createMessage();
        console.error('Error submitting form:', error);
    }
}