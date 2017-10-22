function get(url, callback) {
    if (null == callback) {
        callback = look;
    }

    axios.get(url)
        .then(function (response) {
            callback(response.data);
        })
        .catch(function (error) {
            handel(error);
        });
}

function post(url, data, callback) {
    if (null == callback) {
        callback = look;
    }

    axios.post(url, data)
        .then(function (response) {
            callback(response.data);
        })
        .catch(function (error) {
            handel(error);
        });
}

function handel(error) {
    log(error);
    if (error.response) {
        look(error.response.data.message);
        return;
    }
    look(error.message);
}

function save(url, data, callback) {
    post(url, data, function (json) {
        look(json.text);
        if (callback) {
            callback(json);
            return;
        }
        if (json.url) {
            goto(json.url, json.time);
        }
    });
}

function goto(url, time) {
    if (null == time) {
        time = 999;
    }

    setTimeout(function () {
        location.href = url;
    }, time);
}
