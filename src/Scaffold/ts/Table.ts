
class Table extends Entity.UniqueItem {
    path: string = ''
    name = camel2snake(lowerCapital(this.name))
    field = new Entity.UniqueList<Field>(Field)
    index = new Entity.UniqueList<Index>(Index)

    constructor(name: string) {
        super(name)
        this.field.onAfterNameChange(this.handelNameChange)
    }

    private handelNameChange = (event: Entity.NameChange) => {
        this.index.list.forEach(index => {
            index.field.list.every(field => {
                if (field.name == event.old) {
                    field.name = event.name
                    return false
                }
                return true
            })
        })
    }

}
