
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

        this.nameSpace = 'App';
        this.migrationPath = 'database\\migrations';
        this.modelNameSpace = 'App\\Model';
        this.modelPath = 'app\\Model';
        this.seedlPath = 'database\\factories';
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
        if (isEmpty(data)) {
            data = this.create();
        }
        super.load(data);

        this.entity.load(data.entity.list);
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
        this.factory = new Factory(name, this.table);
        this.model = new Model(name, this.table);
        this.controller = new Controller(name);
        this.form = new Form(name, this.model);
    }

    set(project) {
        this.table.path = project.migrationPath;
        this.model.nameSpace = project.modelNameSpace;
        this.model.path = project.modelPath;
        this.factory.path = project.seedlPath;
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
        this.callbackList = [];
    }

    load(data) {
        super.load(data);

        this.field.load(data.field.list);
        this.index.load(data.index.list);
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

class Factory extends Item {
    constructor(name, table) {
        super(name);
        this.name = name + 'Factory';
        this.table = table;

        this.field = new FactoryFieldList();

        let list = this.field;
        table.register(function(field, name) {
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

    load(data) {
        super.load(data);
        this.field.load(data.field.list);
    }
}

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

        //this.variable = new VariableList();
        this.relation = new RelationList();
        this.validation = new ValidationList();

        let validation = this.validation;
        table.register(function(field, name) {
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

    setInstance(name) {
        this.instance = name;
        this.field.setInstance(name);
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

    setInstance(name) {
        for (let index = 0; index < this.list.length; index++) {
            let field = this.list[index];
            field.vModel = this.form.instance + '.' + field.name;
        }
    }

}
