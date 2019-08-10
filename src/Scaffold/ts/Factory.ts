/// <reference path="./FactoryField.ts" />
/// <reference path="./FieldItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />

class Factory extends FieldItem {
    table: Table
    field = new Entity.UniqueList<FactoryField>(FactoryField)
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
        const list: Array<FactoryField> = []
        this.table.field.list.forEach(field => {
            const found = this.field.find(field.name)
            if (found) {
                list.push(found)
                return
            }

            const fff = this.field.create(field.name, 'raw')
            list.push(fff)
        })

        this.field.clear()
        this.field.list.push(...list)
    }

}
