
class Form extends Entity.UniqueItem {
    _instance: string
    method = 'POST'
    path: string
    model: Model
    field = new Entity.UniqueList<FormField>(FormField)

    constructor(name: string, model: Model) {
        super(name);
        this.name = lowerCapital(name)
        this.model = model;
        this.instance = model.instance;
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

    set instance(name: string) {
        this._instance = name
        this.field.list.forEach(field => field.vModel = name + '.' + field.name);
    }

}
Form.prototype.ignoreList = Entity.UniqueItem.prototype.ignoreList.concat(['model'])
