/// <reference path="./FieldItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />

class Factory extends FieldItem {
    table: Table
    field = new Entity.UniqueList<Field>(Field)
    protected static ignoreList = Entity.UniqueItem.ignoreList.concat(['table'])

    constructor(name: string, table: Table) {
        super(name)
        this.name = snake2camel(upperCapital(name)) + 'Factory'
        this.table = table
        this.table.field.onAfterNameChange(this.handelNameChange)
    }

    get fieldList() {
        return this.field
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
