import AjaxForm from "./modules/AjaxForm.js";

class Main {
    constructor() {
        this.initForms();
    }

    initForms() {
        new AjaxForm('#create-news');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const main = new Main();
});