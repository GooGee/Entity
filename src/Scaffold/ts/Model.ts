
class Model extends FieldItem {
    table: Table
    primaryKey = 'id'
    nameSpace: string
    path: string
    instance: string
    relation = new Entity.UniqueList<Relation>(Relation)
    validation = new Entity.UniqueList<Validation>(Validation)
    protected static ignoreList = Entity.UniqueItem.ignoreList.concat(['table'])

    constructor(name: string, table: Table) {
        super(name)
        this.table = table
        this.name = upperCapital(name)
        this.instance = lowerCapital(name)
        this.table.field.onAfterNameChange(this.handelNameChange)
    }

    get fieldList() {
        return this.validation
    }

    update() {
        this.table.field.list.forEach(field => {
            if (this.validation.find(field.name)) {
                return
            }
            let validation = this.validation.create(field.name)
            this.validation.add(validation)
        })
    }
}
