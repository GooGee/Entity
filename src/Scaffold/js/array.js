
function moveUp(array, item) {
    let index = array.indexOf(item);
    if (index == 0) {
        return;
    }

    let tmp = array[index - 1];
    array[index - 1] = item;
    array[index] = tmp;

    array.splice(0, 0);
}

function moveDown(array, item) {
    let index = array.indexOf(item);
    if (index == array.length - 1) {
        return;
    }

    let tmp = array[index + 1];
    array[index + 1] = item;
    array[index] = tmp;

    array.splice(0, 0);
}

function remove(item, array) {
    let index = array.indexOf(item);
    array.splice(index, 1);
}

function unique(array) {
    return [...new Set(array)];
}
