
class Table extends Entity.UniqueItem {
    path: string = ''
    name = camel2snake(lowerCapital(this.name))
    field = new Entity.UniqueList<Field>(Field)
    index = new Entity.UniqueList<Index>(Index)

    change(field: Field, name: string) {
        let old = field.name
        field.name = name
        this.index.list.forEach(index => {
            let fff = index.field.find(old)
            if (fff) {
                fff.name = name
            }
        })
    }

}
