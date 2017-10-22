
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


function log(text) {
    console.log(text);
}

/**
 * true undefined
 * true null
 * true ''
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
        if (object.length > 0) {
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


class Item {
    constructor(name) {
        this.name = name;
    }

    load(data) {
        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                let item = data[key];
                if ("object" != typeof (item)) {
                    this[key] = item;
                }
            }
        }
    }
}

class List {
    constructor() {
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

        this.entity = new EntityList(this);
    }

    create() {
        let data = {
            nameSpace: 'App',
            migrationPath: 'database\\migrations',
            modelNameSpace: 'App\\Model',
            modelPath: 'app\\Model',
            controllerNameSpace: 'App\\Http\\Controllers',
            controllerPath: 'app\\Http\\Controllers',
            formPath: 'resources\\views',
            entity: {
                list: []
            }
        };

        let user = new Entity('User');
        user.set(data);
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

    load(data){
        if (isEmpty(data)) {
            data = this.create();
        }
        super.load(data);

        this.entity.load(data.entity.list);
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
        this.ignore = true;
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

class Entity extends Item {
    constructor(name) {
        super(name);
        this.name = upperCapital(name);

        this.table = new Table(name);
        this.model = new Model(name, this.table);
        this.controller = new Controller(name);
        this.form = new Form(name, this.model);
    }

    set(project) {
        this.table.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.controller.nameSpace = project.controllerNameSpace;
        this.controller.path = project.controllerPath;
        this.form.path = project.formPath;
    }

    load(data) {
        super.load(data);

        this.table.load(data.table);
        this.model.load(data.model);
        this.controller.load(data.controller);
        this.form.load(data.form);
    }
}

class Table extends Item {
    constructor(name) {
        super(name);
        this.name = camel2snake(lowerCapital(name));
        this.field = new FieldList();
        this.index = new IndexList();
    }

    load(data) {
        super.load(data);

        this.field.load(data.field.list);
        this.index.load(data.index.list);
    }
}

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

    load(data) {
        super.load(data);
        this.field.load(data.field.list);
    }
}

class Model extends Item {
    constructor(name, table) {
        super(name);
        this.name = upperCapital(name);
        this.table = table;
        this.primaryKey = 'id';
        //this.variable = new VariableList();
        this.relation = new RelationList();
        this.validation = new ValidationList();
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

    load(data) {
        super.load(data);

        //this.variable.load(data.variable.list);
        this.relation.load(data.relation.list);
        this.validation.load(data.validation.list);
    }
}

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
        this.rule = new Rule;
    }

    load(data) {
        super.load(data);
        this.rule.load(data.rule);
    }
}

class Rule extends Item {

}

class Controller extends Item {
    constructor(name) {
        super(name);
        this.name = upperCapital(name) + 'Controller';

        this.middleware = new MiddlewareList();
    }

    load(data) {
        super.load(data);
        this.middleware.load(data.middleware.list);
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

        this.method = new List();
    }

    load(data) {
        super.load(data);
        this.method.load(data.method.list);
    }
}

class Form extends Item {
    constructor(name, model) {
        super(name);
        this.name = lowerCapital(name);
        this.model = model;
        this.method = 'POST';
        this.instance = this.name;

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

    load(data) {
        super.load(data);
        this.field.load(data.field.list);
    }
}

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
}

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
