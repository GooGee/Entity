
class Model extends Entity.UniqueItem {
    table: Table
    primaryKey = 'id'
    nameSpace: string
    path: string
    instance: string
    relation = new Entity.UniqueList<Relation>(Relation)
    validation = new Entity.UniqueList<Validation>(Validation)
    
    constructor(name: string, table: Table) {
        super(name)
        this.table = table
        this.name = upperCapital(name)
        this.instance = lowerCapital(name)
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
Model.prototype.ignoreList = Entity.UniqueItem.prototype.ignoreList.concat(['table'])
