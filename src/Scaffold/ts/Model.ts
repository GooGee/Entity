/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./FieldItem.ts" />
/// <reference path="./Relation.ts" />
/// <reference path="./Table.ts" />
/// <reference path="./Validation.ts" />

class Model extends FieldItem {
    table: Table
    primaryKey = 'id'
    nameSpace: string
    instance: string
    relation = new Entity.UniqueList<Relation>(Relation)
    validation = new Entity.UniqueList<Validation>(Validation)
    protected static ignoreList = Entity.UniqueItem.ignoreList.concat(['table'])

    constructor(name: string, table: Table) {
        super(name)
        this.table = table
        this.name = snake2camel(upperCapital(name))
        this.instance = lowerCapital(name)
        this.table.field.onAfterNameChange(this.handelNameChange)
    }

    get fieldList() {
        return this.validation
    }

    update() {
        const list: Array<Validation> = []
        this.table.field.list.forEach(field => {
            const found = this.validation.find(field.name)
            if (found) {
                list.push(found)
                return
            }

            const validation = this.validation.create(field.name)
            list.push(validation)
        })

        this.validation.clear()
        this.validation.list.push(...list)
    }
}
