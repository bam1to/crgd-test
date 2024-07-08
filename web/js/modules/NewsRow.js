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

        newsRow.append(newsTitle, newsDescription, this.getActionButtons());

        let newsContainer = document.querySelector('#news-container');
        if (!newsContainer) {
            newsContainer = this.createNewsContainer();
        }

        newsContainer.append(newsRow);
    }

    /**
     * @param {NewsDto} newsDto 
     */
    update(newsDto) { }

    delete(newsId) {

    }

    getActionButtons() {
        let actionButtonsContainer = document.createElement('div');
        actionButtonsContainer.classList.add('info-row-actions');
        actionButtonsContainer.innerHTML = `
            <button type="button" class="i-btn">
                <i class="i-btn-edit"></i>
            </button>
            <button type="button" class="i-btn">
                <i class="i-btn-close"></i>
            </button>`;
        return actionButtonsContainer;
    }

    createNewsContainer() {
        const newsContainer = document.createElement('div');

        newsContainer.classList.add('sub-container');
        newsContainer.id = 'news-container';
        newsContainer.innerHTML = `<h2 class="sec-h">All News</h2>`;
        const newsCreationForm = document.querySelector('#news-creation-form');

        newsCreationForm.parentNode.insertBefore(newsContainer, newsCreationForm);

        return newsContainer;
    }
}