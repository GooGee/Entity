
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


class JSONItem {
    toJSON() {
        let object = {};
        for (let key in this) {
            if (this.hasOwnProperty(key)) {
                if (this.ignoreList.indexOf(key) >= 0) {
                    continue;
                }
                object[key] = this[key];
            }
        }
        return object;
    }
}
JSONItem.prototype.ignoreList = [];

class Item extends JSONItem {
    constructor(name) {
        super();
        this.name = name;
    }

    load(data) {
        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                if (this.ignoreList.indexOf(key) >= 0) {
                    continue;
                }

                let item = data[key];
                if ("object" == typeof item) {
                    if (this[key].load) {
                        if (item.list) { // class List
                            this[key].load(item.list);
                            continue;
                        }
                        // class Item
                        this[key].load(item);
                        continue;
                    }
                    // normal Object
                }
                this[key] = item;
            }
        }
    }
}

class List extends JSONItem {
    constructor() {
        super();
        this.list = [];
    }

    load(array) {
        for (let index = 0; index < array.length; index++) {
            let data = array[index];
            let item = this.create(data.name);
            item.load(data);
        }
    }

    get(name) {
        for (let index = 0; index < this.list.length; index++) {
            let item = this.list[index];
            if (item.name == name) {
                return item;
            }
        }
        return null;
    }

    create(name) {
        let item = new Item(name);
        this.list.push(item);
        return item;
    }

    remove(item) {
        let index = this.list.indexOf(item);
        this.list.splice(index, 1);
    }

    moveUp(item) {
        moveUp(this.list, item);
    }

    moveDown(item) {
        moveDown(this.list, item);
    }
}

class Project extends Item {
    constructor(name) {
        super(name);

        this.nameSpace = 'App';
        this.migrationPath = 'database\\migrations';
        this.modelNameSpace = 'App\\Model';
        this.modelPath = 'app\\Model';
        this.factoryPath = 'database\\factories';
        this.controllerNameSpace = 'App\\Http\\Controllers';
        this.controllerPath = 'app\\Http\\Controllers';
        this.formPath = 'resources\\views';

        this.entity = new EntityList(this);
    }

    create() {
        let data = {
            entity: {
                list: []
            }
        };

        let user = new Entity('User');
        user.table.field.create('id', 'increments');
        user.table.field.create('name', 'string');
        user.table.field.create('email', 'string');
        user.table.field.create('password', 'string');
        let token = user.table.field.create('remember_token', 'string');
        token.nullable = true;

        let index = user.table.index.create('email', 'unique');
        index.field.create('email');

        data.entity.list.push(user);
        return data
    }

    load(data) {
        if (data) {
            //
        } else {
            data = this.create();
        }
        super.load(data);
    }

    change(key, value) {
        if ('nameSpace' == key) {
            this.changeNameSpace(value);
        }
        this[key] = value;

        let array = this.entity.list;
        for (let index = 0; index < array.length; index++) {
            let entity = array[index];
            entity.set(this);
        }
    }

    changeNameSpace(nameSpace) {
        let ons = this.nameSpace;
        for (let key in this) {
            if (this.hasOwnProperty(key)) {
                let item = this[key];
                if ("object" != typeof (item)) {
                    if (this[key] == ons) {
                        this[key] = nameSpace;
                        continue;
                    }
                    let re = new RegExp('^' + ons + '\\\\');
                    this[key] = item.replace(re, nameSpace + '\\');
                }
            }
        }
    }
}

class VariableList extends List {
    create(name, value) {
        let variable = new Variable(name, value);
        this.list.push(variable);
        return variable;
    }
}

class Variable extends Item {
    constructor(name, value) {
        super(name);
        this.name = name;
        this.value = value;
        this.type = 'string';
    }
}

class EntityList extends List {
    constructor(project) {
        super();
        this.project = project;
    }

    create(name) {
        let entity = new Entity(name);
        entity.set(this.project);
        this.list.push(entity);
        return entity;
    }
}
EntityList.prototype.ignoreList = ['project'];

class Entity extends Item {
    constructor(name) {
        super(name);
        this.name = upperCapital(name);

        this.table = new Table(name);
        this.factory = new Factory(name, this.table);
        this.model = new Model(name, this.table);
        this.controller = new Controller(name);
        this.form = new Form(name, this.model);
    }

    set(project) {
        this.table.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.factory.path = project.factoryPath;
        this.controller.nameSpace = project.controllerNameSpace;
        this.controller.path = project.controllerPath;
        this.form.path = project.formPath;
    }
}

class Table extends Item {
    constructor(name) {
        super(name);
        this.name = camel2snake(lowerCapital(name));

        this.field = new FieldList();
        this.index = new IndexList();
        this.callbackList = [];
    }

    register(callback) {
        this.callbackList.push(callback);
    }

    changeFieldName(field, name) {
        this.onFieldChange(field, name);

        let array = this.index.list;
        for (let iii = 0; iii < array.length; iii++) {
            let index = array[iii];
            let fff = index.field.get(field.name);
            if (fff) {
                fff.name = name;
            }
        }
        field.name = name;
    }

    onFieldChange(field, name) {
        let array = this.callbackList;
        for (let index = 0; index < array.length; index++) {
            let callback = array[index];
            callback(field, name);
        }
    }
}
Table.prototype.ignoreList = ['callbackList'];

class FieldList extends List {
    create(name, type) {
        let field = new Field(name, type);
        this.list.push(field);
        return field;
    }
}

class Field extends Item {
    constructor(name, type) {
        super(name);
        this.name = name;
        this.type = type;
    }
}

class IndexList extends List {
    create(name, type) {
        let index = new Index(name, type);
        this.list.push(index);
        return index;
    }
}

class Index extends Item {
    constructor(name, type) {
        super(name);
        this.name = name;
        this.type = type;

        this.field = new List();
    }
}

class Factory extends Item {
    constructor(name, table) {
        super(name);
        this.name = upperCapital(name) + 'Factory';
        this.table = table;

        this.field = new FactoryFieldList();

        let list = this.field;
        table.register(function (field, name) {
            let item = list.get(field.name);
            if (item) {
                item.name = name;
            }
        });
    }

    update() {
        let array = this.table.field.list;
        for (let index = 0; index < array.length; index++) {
            let field = array[index];
            if (this.field.get(field.name)) {
                continue;
            }
            this.field.create(field.name);
        }
    }
}
Factory.prototype.ignoreList = ['table'];

class FactoryFieldList extends List {
    create(name, type) {
        let field = new Field(name, type);
        field.type = 'raw';
        this.list.push(field);
        return field;
    }
}

class Model extends Item {
    constructor(name, table) {
        super(name);
        this.name = upperCapital(name);
        this.table = table;
        this.primaryKey = 'id';
        this.instance = lowerCapital(name);

        //this.variable = new VariableList();
        this.relation = new RelationList();
        this.validation = new ValidationList();

        let validation = this.validation;
        table.register(function (field, name) {
            let item = validation.get(field.name);
            if (item) {
                item.name = name;
            }
        });
    }

    update() {
        let array = this.table.field.list;
        for (let index = 0; index < array.length; index++) {
            let field = array[index];
            if (this.validation.get(field.name)) {
                continue;
            }
            this.validation.create(field.name);
        }
    }
}
Model.prototype.ignoreList = ['table'];

class RelationList extends List {
    create(name, type) {
        let relation = new Relation(name, type);
        this.list.push(relation);
        return relation;
    }
}

class Relation extends Item {
    constructor(name, type) {
        super(name);
        this.name = lowerCapital(name);
        this.type = type;
        this.model = name;
    }
}
Relation.prototype.ignoreList = ['pivot'];

class ValidationList extends List {
    create(name) {
        let validation = new Validation(name);
        this.list.push(validation);
        return validation;
    }
}

class Validation extends Item {
    constructor(name) {
        super(name);
        this.name = name;
        this.rule = new Item;
    }
}

class Controller extends Item {
    constructor(name) {
        super(name);
        this.name = upperCapital(name) + 'Controller';
        this.blade = lowerCapital(name);

        this.middleware = new MiddlewareList();
    }
}

class MiddlewareList extends List {
    create(name) {
        let mw = new Middleware(name);
        this.list.push(mw);
        return mw;
    }
}

class Middleware extends Item {
    constructor(name) {
        super(name);
        this.name = name;
        this.type = 'all';

        this.method = {};
    }
}

class Form extends Item {
    constructor(name, model) {
        super(name);
        this.name = lowerCapital(name);
        this.model = model;
        this.method = 'POST';
        this.instance = model.instance;

        this.field = new FormFieldList(this);
    }

    update() {
        let array = this.model.validation.list;
        for (let index = 0; index < array.length; index++) {
            let field = array[index];
            if (this.field.get(field.name)) {
                continue;
            }
            this.field.create(field.name, 'text');
        }
    }

    setInstance(name) {
        this.instance = name;
        this.field.setInstance(name);
    }
}
Form.prototype.ignoreList = ['model'];

class FormFieldList extends List {
    constructor(form) {
        super();
        this.form = form;
    }

    create(name, type) {
        let field = new Field(name, type);
        field.vModel = this.form.instance + '.' + name;
        field.label = upperCapital(name);
        this.list.push(field);
        return field;
    }

    setInstance(name) {
        for (let index = 0; index < this.list.length; index++) {
            let field = this.list[index];
            field.vModel = this.form.instance + '.' + field.name;
        }
    }
}
FormFieldList.prototype.ignoreList = ['form'];

function get(url, callback) {
    if (null == callback) {
        callback = alert;
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
        callback = alert;
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
        alert(error.response.data.message);
        return;
    }
    alert(error.message);
}

function save(url, data, callback) {
    post(url, data, function (json) {
        alert(json.text);
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


function log(text) {
    console.log(text);
}

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
