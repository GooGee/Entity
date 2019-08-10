/// <reference path="./FieldItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />

class Form extends FieldItem {
    _instance: string
    method = 'POST'
    model: Model
    field = new Entity.UniqueList<FormField>(FormField)
    protected static ignoreList = Entity.UniqueItem.ignoreList.concat(['model'])

    constructor(name: string, model: Model) {
        super(name);
        this.name = lowerCapital(name)
        this.model = model;
        this.instance = model.instance;
        this.model.validation.onAfterNameChange(this.handelNameChange)
    }

    get fieldList() {
        return this.field
    }

    update() {
        this.model.validation.list.forEach(field => {
            if (this.field.find(field.name)) {
                return
            }
            let fff = this.field.create(field.name, 'text')
            this.field.add(fff)
        })
    }

    get instance(): string {
        return this._instance
    }

    set instance(name: string) {
        this._instance = name
        if (name) {
            name = name + '.'
        } else {
            name = ''
        }
        this.field.list.forEach(field => field.vModel = name + field.name);
    }

}
