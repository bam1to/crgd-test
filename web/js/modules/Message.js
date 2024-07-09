export default class Message {
    #messageSelector
    messageParams

    #messageTypes = ['error', 'success'];

    constructor(messageSelector, messageParams = {}) {
        this.#messageSelector = messageSelector;
        this.messageParams = messageParams;
    }

    createMessage() {
        const messageType = this.#getMessageType(),
            messageText = this.#getMessageText();

        if (!messageType || !messageText) {
            return;
        }

        const messageElem = document.querySelector(this.#messageSelector);

        messageElem.className = '';
        messageElem.classList.add('message', 'message-' + messageType);
        messageElem.innerText = messageText;
        messageElem.style.display = 'block';
    }

    #getMessageType() {
        const passedMessageType = this.messageParams.messageType || null;

        return this.#messageTypes.find(messageType => messageType === passedMessageType);
    }

    #getMessageText() {
        return this.messageParams.messageText || '';
    }
}