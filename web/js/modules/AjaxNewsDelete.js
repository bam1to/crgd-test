export default class AjaxNewsDelete {
    #id;

    constructor(id) {
        this.#id = id;
        this.#delete();
    }

    async #delete() {
        const url = '/admin/news/delete';
        const method = 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                body: {
                    id: this.#id
                }
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
        console.log('Row deleted successfully:', data);
    }

    handleError(error) {
        console.error('Error deleting row:', error);
    }
}