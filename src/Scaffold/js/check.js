
function log(text) {
    console.log(text);
}

/**
 * true undefined
 * true null
 * true ''
 * true ' '
 * true []
 * true {}
 *
 * @param object
 * @returns {boolean}
 */
function isEmpty(object) {
    if (null == object) {
        return true;
    }

    let type = typeof (object);
    if ("string" == type) {
        let string = object.trim();
        if (string.length > 0) {
            return false;
        }
        return true;
    }
    
    if (Array.isArray(object)) {
        if (object.length > 0) {
            return false;
        }
        return true;
    }
    
    if ("object" == type) {
        if (Object.keys(object).length > 0) {
            return false;
        }
        return true;
    }

    return false;
}

function isIE() {
    if (typeof (window.ActiveXObject) != "undefined") {
        return true;
    }
    return "ActiveXObject" in window;
}
