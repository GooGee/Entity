
class Factory extends Entity.UniqueItem {
    path: string = ''
    table: Table
    field = new Entity.UniqueList<Field>(Field)

    constructor(name: string, table: Table) {
        super(name)
        this.name = upperCapital(name) + 'Factory'
        this.table = table
    }

    update() {
        this.table.field.list.forEach(field => {
            if (this.field.find(field.name)) {
                return
            }
            let fff = this.field.create(field.name, 'raw')
            this.field.add(fff)
        })
    }

}
Factory.prototype.ignoreList = Entity.UniqueItem.prototype.ignoreList.concat(['table'])
