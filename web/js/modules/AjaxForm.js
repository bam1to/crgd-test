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
    }

    handleSuccess(data) {
        console.log('Form submitted successfully:', data);
        this.#form.reset();
        // Дополнительная логика обработки успешного ответа
    }

    handleError(error) {
        console.error('Error submitting form:', error);
        // Дополнительная логика обработки ошибок
    }
}