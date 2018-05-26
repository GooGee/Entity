
function log(text) {
    console.log(text);
}

function upperCapital(string) {
    if (!string) {
        return string;
    }

    if (string.match(/^[a-z]/)) {
        return string[0].toUpperCase() + string.substring(1);
    }
    return string;
}

function lowerCapital(string) {
    if (!string) {
        return string;
    }

    if (string.match(/^[A-Z]/)) {
        return string[0].toLowerCase() + string.substring(1);
    }
    return string;
}

function camel2snake(string) {
    if (!string) {
        return string;
    }

    return string.replace(/([A-Z])/g, function (match) {
        return '_' + match.toLowerCase();
    });
}

function snake2camel(string) {
    if (!string) {
        return string;
    }

    return string.replace(/(_[a-z])/g, function (match) {
        return match[1].toUpperCase();
    });
}
