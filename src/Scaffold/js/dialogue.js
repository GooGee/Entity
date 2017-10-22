function look(message, status) {
    alert(message);
}

function sure(message, callback) {
    if (callback) {
        return callback(confirm(message));
    }
    return confirm(message);
}

function input(message, callback) {
    if (callback) {
        return callback(prompt(message));
    }
    return prompt(message);
}

class Choose {
    constructor() {
        this.data = {
            message: '',
            display: null,
            array: [],
            callback: null
        };

        this.hide();
    }

    show(data) {
        if (data) {
            this.data = data;
        }
        this.visible = true;
    }

    hide() {
        this.visible = false;
    }
}
