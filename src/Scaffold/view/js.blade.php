"use strict";
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
var Entity;
(function (Entity) {
    class Item {
        load(data) {
            const ignoreList = Object.getPrototypeOf(this).constructor.ignoreList;
            for (const key of Object.keys(data)) {
                if (ignoreList.indexOf(key) >= 0) {
                    continue;
                }
                let item = data[key];
                if (this[key] && this[key].load) {
                    this[key].load(item);
                    continue;
                }
                this[key] = item;
            }
        }
        toJSON(key) {
            let object = {};
            const ignoreList = Object.getPrototypeOf(this).constructor.ignoreList;
            for (const key of Object.keys(this)) {
                if (ignoreList.indexOf(key) >= 0) {
                    continue;
                }
                object[key] = this[key];
            }
            return object;
        }
    }
    Item.ignoreList = Array();
    Entity.Item = Item;
})(Entity || (Entity = {}));
/// <reference path="./Listener.ts" />
var Entity;
(function (Entity) {
    class Event {
        constructor() {
            this.listeners = [];
            this.on = (listener) => {
                this.listeners.push(listener);
                return {
                    off: () => this.off(listener)
                };
            };
            this.off = (listener) => {
                let index = this.listeners.indexOf(listener);
                if (index > -1)
                    this.listeners.splice(index, 1);
            };
            this.emit = (event) => {
                this.listeners.forEach((listener) => listener(event));
            };
        }
    }
    Entity.Event = Event;
})(Entity || (Entity = {}));
/// <reference path="../Entity/UniqueItem.ts" />
var Entity;
(function (Entity) {
    class NameChange {
        constructor(sender, name, old) {
            this.sender = sender;
            this.name = name;
            this.old = old;
        }
    }
    Entity.NameChange = NameChange;
})(Entity || (Entity = {}));
/// <reference path="./Item.ts" />
/// <reference path="../Event/Event.ts" />
/// <reference path="../Event/NameChange.ts" />
var Entity;
(function (Entity) {
    class UniqueItem extends Entity.Item {
        constructor(name) {
            super();
            this._name = '';
            this.beforeNameChange = new Entity.Event();
            this.afterNameChange = new Entity.Event();
            this.name = name;
        }
        get name() {
            return this._name;
        }
        set name(name) {
            if (this._name == name) {
                return;
            }
            let event = new Entity.NameChange(this, name, this._name);
            this.beforeNameChange.emit(event);
            this._name = name;
            this.afterNameChange.emit(event);
        }
        toJSON(key) {
            let object = super.toJSON(key);
            delete object._name;
            object.name = this.name;
            return object;
        }
        onBeforeNameChange(callback) {
            return this.beforeNameChange.on(callback);
        }
        offBeforeNameChange(callback) {
            this.beforeNameChange.off(callback);
        }
        onAfterNameChange(callback) {
            return this.afterNameChange.on(callback);
        }
        offAfterNameChange(callback) {
            this.afterNameChange.off(callback);
        }
    }
    UniqueItem.ignoreList = Entity.Item.ignoreList.concat(['beforeNameChange', 'afterNameChange']);
    Entity.UniqueItem = UniqueItem;
})(Entity || (Entity = {}));
/// <reference path="./Item.ts" />
/// <reference path="./Newable.ts" />
var Entity;
(function (Entity) {
    class List {
        constructor(type) {
            this.list = Array();
            this.itemType = type;
        }
        create(...args) {
            return new this.itemType(...args);
        }
        add(item) {
            this.list.push(item);
        }
        remove(item) {
            let index = this.list.indexOf(item);
            this.list.splice(index, 1);
        }
        merge(array) {
            array.forEach(item => {
                this.list.push(item);
            });
        }
        moveUp(item) {
            moveUp(this.list, item);
        }
        moveDown(item) {
            moveDown(this.list, item);
        }
        clear() {
            this.list.length = 0;
            this.list.splice(0, 0);
        }
        load(object) {
            let array;
            if (Array.isArray(object)) {
                array = object;
            }
            else {
                if (Array.isArray(object.list)) {
                    array = object.list;
                }
                else {
                    return;
                }
            }
            this.clear();
            array.forEach(one => {
                let item = this.create();
                item.load(one);
                this.add(item);
            });
        }
        toJSON(key) {
            return {
                list: this.list
            };
        }
    }
    Entity.List = List;
})(Entity || (Entity = {}));
/// <reference path="./List.ts" />
/// <reference path="./UniqueItem.ts" />
var Entity;
(function (Entity) {
    class UniqueList extends Entity.List {
        constructor() {
            super(...arguments);
            this.afterNameChange = new Entity.Event();
            this.handelBeforeNameChange = (event) => {
                this.invalidThrow(event.name);
            };
            this.handelAfterNameChange = (event) => {
                this.afterNameChange.emit(event);
            };
        }
        find(name) {
            let found = null;
            this.list.every(item => {
                if (item.name == name) {
                    found = item;
                    return false;
                }
                return true;
            });
            return found;
        }
        add(item) {
            this.invalidThrow(item.name);
            item.onBeforeNameChange(this.handelBeforeNameChange);
            item.onAfterNameChange(this.handelAfterNameChange);
            this.list.push(item);
        }
        remove(item) {
            super.remove(item);
            item.offBeforeNameChange(this.handelBeforeNameChange);
            item.offAfterNameChange(this.handelAfterNameChange);
        }
        merge(array) {
            array.forEach(item => {
                if (this.find(item.name)) {
                    return;
                }
                this.list.push(item);
            });
        }
        invalidThrow(name) {
            if (Array.isArray(name.match(/^[a-z_A-Z][a-z_A-Z\d]*$/))) {
                // ok
            }
            else {
                throw 'Invalid name!';
            }
            if (this.find(name)) {
                throw name + ' already exists!';
            }
        }
        onAfterNameChange(callback) {
            return this.afterNameChange.on(callback);
        }
        offAfterNameChange(callback) {
            this.afterNameChange.off(callback);
        }
    }
    Entity.UniqueList = UniqueList;
})(Entity || (Entity = {}));
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
class Controller extends Entity.UniqueItem {
    constructor(name) {
        super(name);
        this.middleware = new Entity.UniqueList(Middleware);
        this.blade = lowerCapital(this.name);
        this.name = snake2camel(upperCapital(this.name)) + 'Controller';
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
class FactoryField extends Entity.UniqueItem {
    constructor(name, type) {
        super(name);
        this.method = null;
        this.parameters = null;
        this.property = null;
        this.raw = null;
        this.unique = false;
        this.type = type;
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
class FieldItem extends Entity.UniqueItem {
    constructor() {
        super(...arguments);
        this.handelNameChange = (event) => {
            this.fieldList.list.every(field => {
                if (field.name == event.old) {
                    field.name = event.name;
                    return false;
                }
                return true;
            });
        };
    }
}
/// <reference path="./FactoryField.ts" />
/// <reference path="./FieldItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
class Factory extends FieldItem {
    constructor(name, table) {
        super(name);
        this.field = new Entity.UniqueList(FactoryField);
        this.name = snake2camel(upperCapital(name)) + 'Factory';
        this.table = table;
        this.table.field.onAfterNameChange(this.handelNameChange);
    }
    get fieldList() {
        return this.field;
    }
    update() {
        const list = [];
        this.table.field.list.forEach(field => {
            const found = this.field.find(field.name);
            if (found) {
                list.push(found);
                return;
            }
            const fff = this.field.create(field.name, 'raw');
            list.push(fff);
        });
        this.field.clear();
        this.field.list.push(...list);
    }
}
Factory.ignoreList = Entity.UniqueItem.ignoreList.concat(['table']);
/// <reference path="./Entity/UniqueItem.ts" />
class Field extends Entity.UniqueItem {
    constructor(name, type, value, allowNull = false) {
        super(name);
        this.allowNull = false;
        this.comment = null;
        /**
         * if length is null
         * means field has no length
         * or length is provided automatically
         */
        this.length = null;
        /**
         * if value is null
         * means field has no default value
         */
        this.value = null;
        this.type = type;
        this.value = value;
        this.allowNull = allowNull;
    }
}
class EnumField extends Field {
    constructor(name, type) {
        super(name, type, 0);
        this.list = [];
    }
}
class IncrementField extends Field {
    constructor(name, type) {
        super(name, type, null);
    }
}
class IntegerField extends Field {
    constructor(name, type) {
        super(name, type, 0);
        this.length = 9;
    }
}
class RealField extends Field {
    constructor(name, type) {
        super(name, type, 0);
        this.length = '11, 2';
    }
}
class StringField extends Field {
    constructor(name, type, length = null, value = "''") {
        super(name, type, value);
        this.length = length;
    }
}
class TextField extends Field {
    constructor(name, type) {
        super(name, type, "''");
    }
}
class TimeStamp extends Field {
    constructor(name, type) {
        super(name, type, null, true);
    }
}
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./Field.ts" />
class FieldManager extends Entity.UniqueList {
    clone(field) {
        const fff = new Field(field.name, field.type, field.value, field.allowNull);
        fff.load(field);
        return fff;
    }
    create(name, type) {
        const field = FieldManager.findFieldType(type);
        if (field) {
            const fff = this.clone(field);
            fff.name = name;
            return fff;
        }
        throw new Error('Unknown field type!');
    }
    load(object) {
        let array;
        if (Array.isArray(object)) {
            array = object;
        }
        else {
            if (Array.isArray(object.list)) {
                array = object.list;
            }
            else {
                return;
            }
        }
        this.clear();
        array.forEach(item => {
            const field = this.clone(item);
            this.add(field);
        });
    }
    static findFieldType(type) {
        return FieldTypeList.find(field => {
            return field.type == type;
        });
    }
}
const CommonFieldList = [
    new IncrementField('id', 'increments'),
    new IntegerField('user_id', 'integer'),
    new IntegerField('category_id', 'integer'),
    new IntegerField('parent_id', 'integer'),
    new IntegerField('sort', 'integer'),
    new IntegerField('status', 'integer'),
    new StringField('name', 'string', 11, null),
    new StringField('title', 'string', 33, null),
    new StringField('email', 'string', 33, null),
    new StringField('phone', 'char', 11),
    new StringField('password', 'string', null, null),
    new Field('remember_token', 'string', null, true),
    new TimeStamp('created_at', 'timestamp'),
    new TimeStamp('updated_at', 'timestamp'),
    new TimeStamp('deleted_at', 'timestamp'),
];
const FieldTypeList = [
    new IncrementField('bigIncrements', 'bigIncrements'),
    new IncrementField('increments', 'increments'),
    new IncrementField('mediumIncrements', 'mediumIncrements'),
    new IncrementField('smallIncrements', 'smallIncrements'),
    new IncrementField('tinyIncrements', 'tinyIncrements'),
    new IntegerField('bigInteger', 'bigInteger'),
    new IntegerField('integer', 'integer'),
    new IntegerField('mediumInteger', 'mediumInteger'),
    new IntegerField('smallInteger', 'smallInteger'),
    new IntegerField('tinyInteger', 'tinyInteger'),
    new IntegerField('unsignedBigInteger', 'unsignedBigInteger'),
    new IntegerField('unsignedInteger', 'unsignedInteger'),
    new IntegerField('unsignedMediumInteger', 'unsignedMediumInteger'),
    new IntegerField('unsignedSmallInteger', 'unsignedSmallInteger'),
    new IntegerField('unsignedTinyInteger', 'unsignedTinyInteger'),
    new Field('binary', 'binary', null, true),
    new Field('boolean', 'boolean', false),
    new StringField('char', 'char'),
    new StringField('string', 'string'),
    new TextField('text', 'text'),
    new TextField('mediumText', 'mediumText'),
    new TextField('longText', 'longText'),
    new Field('date', 'date', '2000-01-01'),
    new Field('dateTime', 'dateTime', '2000-01-01 00:00:00'),
    new Field('dateTimeTz', 'dateTimeTz', '2000-01-01 00:00:00'),
    new RealField('decimal', 'decimal'),
    new RealField('double', 'double'),
    new RealField('float', 'float'),
    new RealField('unsignedDecimal', 'unsignedDecimal'),
    new EnumField('enum', 'enum'),
    new Field('time', 'time', '00:00:00'),
    new Field('timeTz', 'timeTz', '00:00:00'),
    new TimeStamp('timestamp', 'timestamp'),
    new TimeStamp('timestampTz', 'timestampTz'),
    new Field('uuid', 'uuid', null),
    new Field('year', 'year', '2000'),
    new Field('geometry', 'geometry', null),
    new Field('geometryCollection', 'geometryCollection', null),
    new Field('ipAddress', 'ipAddress', null),
    new Field('json', 'json', null),
    new Field('jsonb', 'jsonb', null),
    new Field('lineString', 'lineString', null),
    new Field('multiLineString', 'multiLineString', null),
    new Field('macAddress', 'macAddress', null),
    new Field('morphs', 'morphs', null),
    new Field('nullableMorphs', 'nullableMorphs', null),
    new Field('point', 'point', null),
    new Field('multiPoint', 'multiPoint', null),
    new Field('polygon', 'polygon', null),
    new Field('multiPolygon', 'multiPolygon', null),
];
/**
 * Laravel 5.8
 */
const TypeNameList = [
    'bigIncrements',
    'bigInteger',
    'binary',
    'boolean',
    'char',
    'date',
    'dateTime',
    'dateTimeTz',
    'decimal',
    'double',
    'enum',
    'float',
    'geometry',
    'geometryCollection',
    'increments',
    'integer',
    'ipAddress',
    'json',
    'jsonb',
    'lineString',
    'longText',
    'macAddress',
    'mediumIncrements',
    'mediumInteger',
    'mediumText',
    'morphs',
    'multiLineString',
    'multiPoint',
    'multiPolygon',
    'nullableMorphs',
    'nullableTimestamps',
    'point',
    'polygon',
    'rememberToken',
    'smallIncrements',
    'smallInteger',
    'softDeletes',
    'softDeletesTz',
    'string',
    'text',
    'time',
    'timeTz',
    'timestamp',
    'timestampTz',
    'tinyIncrements',
    'tinyInteger',
    'unsignedBigInteger',
    'unsignedDecimal',
    'unsignedInteger',
    'unsignedMediumInteger',
    'unsignedSmallInteger',
    'unsignedTinyInteger',
    'uuid',
    'year',
];
/// <reference path="./FieldItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
class Form extends FieldItem {
    constructor(name, model) {
        super(name);
        this.method = 'POST';
        this.field = new Entity.UniqueList(FormField);
        this.name = lowerCapital(name);
        this.model = model;
        this.instance = model.instance;
        this.model.validation.onAfterNameChange(this.handelNameChange);
    }
    get fieldList() {
        return this.field;
    }
    update() {
        this.model.validation.list.forEach(field => {
            if (this.field.find(field.name)) {
                return;
            }
            let fff = this.field.create(field.name, 'text');
            this.field.add(fff);
        });
    }
    get instance() {
        return this._instance;
    }
    set instance(name) {
        this._instance = name;
        if (name) {
            name = name + '.';
        }
        else {
            name = '';
        }
        this.field.list.forEach(field => field.vModel = name + field.name);
    }
}
Form.ignoreList = Entity.UniqueItem.ignoreList.concat(['model']);
/// <reference path="./Entity/UniqueItem.ts" />
class FormField extends Entity.UniqueItem {
    constructor(name, type, value) {
        super(name);
        this.type = type;
        this.value = value;
        this.vModel = name;
        this.label = upperCapital(name);
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
class Index extends Entity.UniqueItem {
    constructor(name, type) {
        super(name);
        this.field = new Entity.UniqueList(Field);
        this.type = type;
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
class Middleware extends Entity.UniqueItem {
    constructor() {
        super(...arguments);
        this.type = 'all';
        this.method = new Entity.Item;
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
class Relation extends Entity.UniqueItem {
    constructor(name, type) {
        super(name);
        this.pivot = '';
        this.foreignKey = '';
        this.otherKey = '';
        this.name = lowerCapital(name);
        this.type = type;
        this.model = name;
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./FieldManager.ts" />
class Table extends Entity.UniqueItem {
    constructor(name) {
        super(name);
        this.field = new FieldManager(Field);
        this.index = new Entity.UniqueList(Index);
        this.factory = new Factory(this.name, this);
        this.model = new Model(this.name, this);
        this.controller = new Controller(this.name);
        this.form = new Form(this.name, this.model);
        this.handelNameChange = (event) => {
            this.index.list.forEach(index => {
                index.field.list.every(field => {
                    if (field.name == event.old) {
                        field.name = event.name;
                        return false;
                    }
                    return true;
                });
            });
        };
        this.name = camel2snake(lowerCapital(this.name));
        this.field.onAfterNameChange(this.handelNameChange);
    }
    from(project) {
        this.model.nameSpace = project.modelNameSpace;
        this.controller.nameSpace = project.controllerNameSpace;
    }
}
/// <reference path="./Entity/Item.ts" />
/// <reference path="./Entity/UniqueItem.ts" />
class Validation extends Entity.UniqueItem {
    constructor() {
        super(...arguments);
        this.rule = new Entity.Item;
    }
}
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./FieldItem.ts" />
/// <reference path="./Relation.ts" />
/// <reference path="./Table.ts" />
/// <reference path="./Validation.ts" />
class Model extends FieldItem {
    constructor(name, table) {
        super(name);
        this.primaryKey = 'id';
        this.relation = new Entity.UniqueList(Relation);
        this.validation = new Entity.UniqueList(Validation);
        this.table = table;
        this.name = snake2camel(upperCapital(name));
        this.instance = lowerCapital(name);
        this.table.field.onAfterNameChange(this.handelNameChange);
    }
    get fieldList() {
        return this.validation;
    }
    update() {
        const list = [];
        this.table.field.list.forEach(field => {
            const found = this.validation.find(field.name);
            if (found) {
                list.push(found);
                return;
            }
            const validation = this.validation.create(field.name);
            list.push(validation);
        });
        this.validation.clear();
        this.validation.list.push(...list);
    }
}
Model.ignoreList = Entity.UniqueItem.ignoreList.concat(['table']);
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./Table.ts" />
class Project extends Entity.UniqueItem {
    constructor() {
        super(...arguments);
        this.version = 3.0;
        this.nameSpace = 'App';
        this.modelNameSpace = 'App\\Model';
        this.controllerNameSpace = 'App\\Http\\Controllers';
        this.table = new Entity.UniqueList(Table);
    }
    change(key, value) {
        if ('nameSpace' == key) {
            this.changeNameSpace(value);
        }
        this[key] = value;
        this.table.list.forEach(table => table.from(this));
    }
    changeNameSpace(nameSpace) {
        for (const key of Object.keys(this)) {
            let item = this[key];
            if ("string" == typeof item) {
                if (this[key] == this.nameSpace) {
                    this[key] = nameSpace;
                    continue;
                }
                let re = new RegExp('^' + this.nameSpace + '\\\\');
                this[key] = item.replace(re, nameSpace + '\\');
            }
        }
    }
}
/// <reference path="./UniqueItem.ts" />
var Entity;
(function (Entity) {
    class OwnerItem extends Entity.UniqueItem {
        constructor(name, owner) {
            super(name);
            this.owner = owner;
        }
    }
    OwnerItem.ignoreList = Entity.UniqueItem.ignoreList.concat(['owner']);
    Entity.OwnerItem = OwnerItem;
})(Entity || (Entity = {}));
/// <reference path="./UniqueItem.ts" />
/// <reference path="./UniqueList.ts" />
var Entity;
(function (Entity) {
    class OwnerList extends Entity.UniqueList {
        constructor(type, owner) {
            super(type);
            this.owner = owner;
        }
        create(name) {
            return new this.itemType(name, this.owner);
        }
    }
    Entity.OwnerList = OwnerList;
})(Entity || (Entity = {}));
