import NewsDto from "../dto/ NewsDto.js";

export default class NewsRow {

    /**
     * @param {NewsDto} newsDto 
     */
    create(newsDto) {
        const newsRow = document.createElement('div');
        newsRow.classList.add('info-row');
        newsRow.dataset.newsId = newsDto.newsId;

        const newsTitle = document.createElement('div');
        newsTitle.classList.add('info-row-title');
        newsTitle.textContent = newsDto.newsTitle;

        const newsDescription = document.createElement('div');
        newsDescription.classList.add('info-row-description');
        newsDescription.textContent = newsDto.newsDescription;

        newsRow.append(newsTitle, newsDescription, this.#getActionButtons());

        let newsContainer = document.querySelector('#news-container');
        if (!newsContainer) {
            newsContainer = this.#createNewsContainer();
        }

        newsContainer.append(newsRow);
    }

    /**
     * 
     * @param {int} newsId 
     */
    update(newsId) {
        const newsRow = document.querySelector(`[data-news-id="${newsId}"]`);
        const newsRowNewTitle = document.querySelector('#news-title').value,
            newsRowNewDescription = document.querySelector('#news-description').value;

        newsRow.querySelector('.info-row-title').innerText = newsRowNewTitle;
        newsRow.querySelector('.info-row-description').innerText = newsRowNewDescription;
    }

    delete(newsId) {
        const newsRow = document.querySelector(`[data-news-id="${newsId}"]`);

        if (!newsRow) {
            return;
        }

        newsRow.remove();

        // check whether there remain any news rows
        if (document.querySelectorAll('[data-news-id]').length === 0) {
            this.#destroyNewsContainer();
        }
    }

    #getActionButtons() {
        let actionButtonsContainer = document.createElement('div');
        actionButtonsContainer.classList.add('info-row-actions');
        actionButtonsContainer.innerHTML = `
            <button type="button" class="i-btn" data-action="edit">
                <i class="i-btn-edit"></i>
            </button>
            <button type="button" class="i-btn" data-action="delete">
                <i class="i-btn-close"></i>
            </button>`;
        return actionButtonsContainer;
    }

    #createNewsContainer() {
        const newsContainer = document.createElement('div');

        newsContainer.classList.add('sub-container');
        newsContainer.id = 'news-container';
        newsContainer.innerHTML = `<h2 class="sec-h">All News</h2>`;
        const newsCreationForm = document.querySelector('#news-creation-form');

        newsCreationForm.parentNode.insertBefore(newsContainer, newsCreationForm);

        return newsContainer;
    }

    #destroyNewsContainer() {
        const newsContainer = document.querySelector('#news-container');
        newsContainer.remove();
    }
}