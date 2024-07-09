import Message from "./Message.js";
import NewsRow from "./NewsRow.js";

export default class AjaxNewsDelete {
    #id;

    constructor(id) {
        this.#id = id;
        this.#delete();
    }

    async #delete() {
        const formType = document.querySelector('form[data-role]');
        if (formType.dataset.role === 'edit') {
            alert('You cannot delete elements while editing!');
            return;
        }

        const url = '/news/delete';
        const method = 'POST';

        const formData = new FormData();
        formData.append('id', this.#id);

        try {
            const response = await fetch(url, {
                method: method,
                body: formData,
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
        console.log('Row deleted successfully:', data);
        let message = new Message('.message', { messageText: 'News was successfull deleted', messageType: 'success' });
        message.createMessage();
        const newsRow = new NewsRow();
        newsRow.delete(this.#id);
    }

    handleError(error) {
        console.error('Error deleting row:', error);
        let message = new Message('.message', { messageText: error.statusText, messageType: 'error' });
        message.createMessage();
    }
}