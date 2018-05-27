"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
function moveUp(array, item) {
    var index = array.indexOf(item);
    if (index == 0) {
        return;
    }
    var tmp = array[index - 1];
    array[index - 1] = item;
    array[index] = tmp;
    array.splice(0, 0);
}
function moveDown(array, item) {
    var index = array.indexOf(item);
    if (index == array.length - 1) {
        return;
    }
    var tmp = array[index + 1];
    array[index + 1] = item;
    array[index] = tmp;
    array.splice(0, 0);
}
function remove(item, array) {
    var index = array.indexOf(item);
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
    var Item = /** @class */ (function () {
        function Item() {
        }
        Item.prototype.load = function (data) {
            var ignoreList = Object.getPrototypeOf(this).constructor.ignoreList;
            for (var _i = 0, _a = Object.keys(data); _i < _a.length; _i++) {
                var key = _a[_i];
                if (ignoreList.indexOf(key) >= 0) {
                    continue;
                }
                var item = data[key];
                if (this[key] && this[key].load) {
                    this[key].load(item);
                    continue;
                }
                this[key] = item;
            }
        };
        Item.prototype.toJSON = function (key) {
            var object = {};
            var ignoreList = Object.getPrototypeOf(this).constructor.ignoreList;
            for (var _i = 0, _a = Object.keys(this); _i < _a.length; _i++) {
                var key_1 = _a[_i];
                if (ignoreList.indexOf(key_1) >= 0) {
                    continue;
                }
                object[key_1] = this[key_1];
            }
            return object;
        };
        Item.ignoreList = Array();
        return Item;
    }());
    Entity.Item = Item;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var List = /** @class */ (function () {
        function List(type) {
            this.list = Array();
            this.itemType = type;
        }
        List.prototype.create = function () {
            var args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                args[_i] = arguments[_i];
            }
            return new ((_a = this.itemType).bind.apply(_a, [void 0].concat(args)))();
            var _a;
        };
        List.prototype.add = function (item) {
            this.list.push(item);
        };
        List.prototype.remove = function (item) {
            var index = this.list.indexOf(item);
            this.list.splice(index, 1);
        };
        List.prototype.moveUp = function (item) {
            moveUp(this.list, item);
        };
        List.prototype.moveDown = function (item) {
            moveDown(this.list, item);
        };
        List.prototype.clear = function () {
            this.list.length = 0;
            this.list.splice(0, 0);
        };
        List.prototype.load = function (object) {
            var _this = this;
            var array;
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
            array.forEach(function (one) {
                var item = _this.create();
                item.load(one);
                _this.add(item);
            });
        };
        List.prototype.toJSON = function (key) {
            return {
                list: this.list
            };
        };
        return List;
    }());
    Entity.List = List;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var UniqueItem = /** @class */ (function (_super) {
        __extends(UniqueItem, _super);
        function UniqueItem(name) {
            var _this = _super.call(this) || this;
            _this._name = '';
            _this.beforeNameChange = new Entity.Event();
            _this.afterNameChange = new Entity.Event();
            _this.name = name;
            return _this;
        }
        Object.defineProperty(UniqueItem.prototype, "name", {
            get: function () {
                return this._name;
            },
            set: function (name) {
                if (this._name == name) {
                    return;
                }
                var event = new Entity.NameChange(this, name);
                this.beforeNameChange.emit(event);
                this._name = name;
                this.afterNameChange.emit(event);
            },
            enumerable: true,
            configurable: true
        });
        UniqueItem.prototype.onBeforeNameChange = function (callback) {
            return this.beforeNameChange.on(callback);
        };
        UniqueItem.prototype.offBeforeNameChange = function (callback) {
            this.beforeNameChange.off(callback);
        };
        UniqueItem.prototype.onAfterNameChange = function (callback) {
            return this.afterNameChange.on(callback);
        };
        UniqueItem.prototype.offAfterNameChange = function (callback) {
            this.afterNameChange.off(callback);
        };
        UniqueItem.ignoreList = Entity.Item.ignoreList.concat(['beforeNameChange', 'afterNameChange']);
        return UniqueItem;
    }(Entity.Item));
    Entity.UniqueItem = UniqueItem;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var UniqueList = /** @class */ (function (_super) {
        __extends(UniqueList, _super);
        function UniqueList() {
            var _this = _super !== null && _super.apply(this, arguments) || this;
            _this.handelNameChange = function (event) {
                _this.invalidThrow(event.name);
            };
            return _this;
        }
        UniqueList.prototype.find = function (name) {
            var found = null;
            this.list.every(function (item) {
                if (item.name == name) {
                    found = item;
                    return false;
                }
                return true;
            });
            return found;
        };
        UniqueList.prototype.invalidThrow = function (name) {
            if (Array.isArray(name.match(/^[a-z_A-Z][a-z_A-Z\d]*$/))) {
                // ok
            }
            else {
                throw 'Invalid name!';
            }
            if (this.find(name)) {
                throw name + ' already exists!';
            }
        };
        UniqueList.prototype.add = function (item) {
            this.invalidThrow(item.name);
            item.onBeforeNameChange(this.handelNameChange);
            this.list.push(item);
        };
        UniqueList.prototype.remove = function (item) {
            _super.prototype.remove.call(this, item);
            item.offBeforeNameChange(this.handelNameChange);
        };
        UniqueList.prototype.merge = function (array) {
            var _this = this;
            var list = [];
            array.forEach(function (item) {
                if (_this.find(item.name)) {
                    return;
                }
                list.push(item);
            });
            return this.list.concat(list);
        };
        UniqueList.prototype.load = function (object) {
            var _this = this;
            var array;
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
            array.forEach(function (one) {
                var item = _this.create(one.name);
                item.load(one);
                _this.add(item);
            });
        };
        return UniqueList;
    }(Entity.List));
    Entity.UniqueList = UniqueList;
})(Entity || (Entity = {}));
/// <reference path="./Entity/Item.ts" />
/// <reference path="./Entity/Newable.ts" />
/// <reference path="./Entity/List.ts" />
/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
var AAA = '';
var Controller = /** @class */ (function (_super) {
    __extends(Controller, _super);
    function Controller() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.name = upperCapital(_this.name) + 'Controller';
        _this.blade = lowerCapital(_this.name);
        _this.middleware = new Entity.UniqueList(Middleware);
        return _this;
    }
    return Controller;
}(Entity.UniqueItem));
var Entry = /** @class */ (function (_super) {
    __extends(Entry, _super);
    function Entry() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.name = upperCapital(_this.name);
        _this.table = new Table(_this.name);
        _this.factory = new Factory(_this.name, _this.table);
        _this.model = new Model(_this.name, _this.table);
        _this.controller = new Controller(_this.name);
        _this.form = new Form(_this.name, _this.model);
        return _this;
    }
    Entry.prototype.from = function (project) {
        this.table.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.factory.path = project.factoryPath;
        this.controller.nameSpace = project.controllerNameSpace;
        this.controller.path = project.controllerPath;
        this.form.path = project.formPath;
    };
    return Entry;
}(Entity.UniqueItem));
var Factory = /** @class */ (function (_super) {
    __extends(Factory, _super);
    function Factory(name, table) {
        var _this = _super.call(this, name) || this;
        _this.path = '';
        _this.field = new Entity.UniqueList(Field);
        _this.name = upperCapital(name) + 'Factory';
        _this.table = table;
        return _this;
    }
    Factory.prototype.update = function () {
        var _this = this;
        this.table.field.list.forEach(function (field) {
            if (_this.field.find(field.name)) {
                return;
            }
            var fff = _this.field.create(field.name, 'raw');
            _this.field.add(fff);
        });
    };
    Factory.ignoreList = Entity.UniqueItem.ignoreList.concat(['table']);
    return Factory;
}(Entity.UniqueItem));
var Field = /** @class */ (function (_super) {
    __extends(Field, _super);
    function Field(name, type, value, length) {
        var _this = _super.call(this, name) || this;
        _this.type = type;
        _this.value = value;
        _this.length = length;
        return _this;
    }
    return Field;
}(Entity.UniqueItem));
var Form = /** @class */ (function (_super) {
    __extends(Form, _super);
    function Form(name, model) {
        var _this = _super.call(this, name) || this;
        _this.method = 'POST';
        _this.field = new Entity.UniqueList(FormField);
        _this.name = lowerCapital(name);
        _this.model = model;
        _this.instance = model.instance;
        return _this;
    }
    Form.prototype.update = function () {
        var _this = this;
        this.model.validation.list.forEach(function (field) {
            if (_this.field.find(field.name)) {
                return;
            }
            var fff = _this.field.create(field.name, 'text');
            _this.field.add(fff);
        });
    };
    Object.defineProperty(Form.prototype, "instance", {
        get: function () {
            return this._instance;
        },
        set: function (name) {
            this._instance = name;
            if (name) {
                name = name + '.';
            }
            else {
                name = '';
            }
            this.field.list.forEach(function (field) { return field.vModel = name + field.name; });
        },
        enumerable: true,
        configurable: true
    });
    Form.ignoreList = Entity.UniqueItem.ignoreList.concat(['model']);
    return Form;
}(Entity.UniqueItem));
var FormField = /** @class */ (function (_super) {
    __extends(FormField, _super);
    function FormField(name, type, value) {
        var _this = _super.call(this, name) || this;
        _this.type = type;
        _this.value = value;
        _this.vModel = name;
        _this.label = upperCapital(name);
        return _this;
    }
    return FormField;
}(Entity.UniqueItem));
var Index = /** @class */ (function (_super) {
    __extends(Index, _super);
    function Index(name, type) {
        var _this = _super.call(this, name) || this;
        _this.field = new Entity.UniqueList(Field);
        _this.type = type;
        return _this;
    }
    return Index;
}(Entity.UniqueItem));
var Middleware = /** @class */ (function (_super) {
    __extends(Middleware, _super);
    function Middleware() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.type = 'all';
        _this.method = new Entity.Item;
        return _this;
    }
    return Middleware;
}(Entity.UniqueItem));
var Model = /** @class */ (function (_super) {
    __extends(Model, _super);
    function Model(name, table) {
        var _this = _super.call(this, name) || this;
        _this.primaryKey = 'id';
        _this.relation = new Entity.UniqueList(Relation);
        _this.validation = new Entity.UniqueList(Validation);
        _this.table = table;
        _this.name = upperCapital(name);
        _this.instance = lowerCapital(name);
        return _this;
    }
    Model.prototype.update = function () {
        var _this = this;
        this.table.field.list.forEach(function (field) {
            if (_this.validation.find(field.name)) {
                return;
            }
            var validation = _this.validation.create(field.name);
            _this.validation.add(validation);
        });
    };
    Model.ignoreList = Entity.UniqueItem.ignoreList.concat(['table']);
    return Model;
}(Entity.UniqueItem));
var Project = /** @class */ (function (_super) {
    __extends(Project, _super);
    function Project() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.version = 2.0;
        _this.nameSpace = 'App';
        _this.migrationPath = 'database\\migrations';
        _this.modelNameSpace = 'App\\Model';
        _this.modelPath = 'app\\Model';
        _this.factoryPath = 'database\\factories';
        _this.controllerNameSpace = 'App\\Http\\Controllers';
        _this.controllerPath = 'app\\Http\\Controllers';
        _this.formPath = 'resources\\views';
        _this.entry = new Entity.UniqueList(Entry);
        return _this;
    }
    Project.prototype.change = function (key, value) {
        var _this = this;
        if ('nameSpace' == key) {
            this.changeNameSpace(value);
        }
        this[key] = value;
        this.entry.list.forEach(function (entry) { return entry.from(_this); });
    };
    Project.prototype.changeNameSpace = function (nameSpace) {
        var ns = this.nameSpace;
        for (var key in this) {
            if (this.hasOwnProperty(key)) {
                var item = this[key];
                if ("string" == typeof item) {
                    if (this[key] == ns) {
                        this[key] = nameSpace;
                        continue;
                    }
                    var re = new RegExp('^' + ns + '\\\\');
                    this[key] = item.replace(re, nameSpace + '\\');
                }
            }
        }
    };
    return Project;
}(Entity.UniqueItem));
var Relation = /** @class */ (function (_super) {
    __extends(Relation, _super);
    function Relation(name, type) {
        var _this = _super.call(this, name) || this;
        _this.name = lowerCapital(name);
        _this.type = type;
        _this.model = name;
        return _this;
    }
    return Relation;
}(Entity.UniqueItem));
var Table = /** @class */ (function (_super) {
    __extends(Table, _super);
    function Table() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.path = '';
        _this.name = camel2snake(lowerCapital(_this.name));
        _this.field = new Entity.UniqueList(Field);
        _this.index = new Entity.UniqueList(Index);
        return _this;
    }
    Table.prototype.change = function (field, name) {
        var old = field.name;
        field.name = name;
        this.index.list.forEach(function (index) {
            var fff = index.field.find(old);
            if (fff) {
                fff.name = name;
            }
        });
    };
    return Table;
}(Entity.UniqueItem));
var Validation = /** @class */ (function (_super) {
    __extends(Validation, _super);
    function Validation() {
        var _this = _super !== null && _super.apply(this, arguments) || this;
        _this.rule = new Entity.Item;
        return _this;
    }
    return Validation;
}(Entity.UniqueItem));
var Entity;
(function (Entity) {
    var OwnerItem = /** @class */ (function (_super) {
        __extends(OwnerItem, _super);
        function OwnerItem(name, owner) {
            var _this = _super.call(this, name) || this;
            _this.owner = owner;
            return _this;
        }
        OwnerItem.ignoreList = Entity.UniqueItem.ignoreList.concat(['owner']);
        return OwnerItem;
    }(Entity.UniqueItem));
    Entity.OwnerItem = OwnerItem;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var OwnerList = /** @class */ (function (_super) {
        __extends(OwnerList, _super);
        function OwnerList(type, owner) {
            var _this = _super.call(this, type) || this;
            _this.owner = owner;
            return _this;
        }
        OwnerList.prototype.create = function (name) {
            return new this.itemType(name, this.owner);
        };
        return OwnerList;
    }(Entity.UniqueList));
    Entity.OwnerList = OwnerList;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var Event = /** @class */ (function () {
        function Event() {
            var _this = this;
            this.listeners = [];
            this.on = function (listener) {
                _this.listeners.push(listener);
                return {
                    off: function () { return _this.off(listener); }
                };
            };
            this.off = function (listener) {
                var index = _this.listeners.indexOf(listener);
                if (index > -1)
                    _this.listeners.splice(index, 1);
            };
            this.emit = function (event) {
                _this.listeners.forEach(function (listener) { return listener(event); });
            };
        }
        return Event;
    }());
    Entity.Event = Event;
})(Entity || (Entity = {}));
var Entity;
(function (Entity) {
    var NameChange = /** @class */ (function () {
        function NameChange(sender, name) {
            this.sender = sender;
            this.name = name;
        }
        return NameChange;
    }());
    Entity.NameChange = NameChange;
})(Entity || (Entity = {}));
