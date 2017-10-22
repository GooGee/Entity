
function upperCapital(str) {
    if (str.match(/^[a-z]/)) {
        return str[0].toUpperCase() + str.substring(1);
    }
    return str;
}

function lowerCapital(str) {
    if (str.match(/^[A-Z]/)) {
        return str[0].toLowerCase() + str.substring(1);
    }
    return str;
}

function camel2snake(str) {
    return str.replace(/([A-Z])/g, function (match) {
        return '_' + match.toLowerCase();
    });
}

function snake2camel(str) {
    return str.replace(/(_[a-z])/g, function (match) {
        return match[1].toUpperCase();
    });
}
