
class FieldItem extends Entity.UniqueItem {
    field: Entity.UniqueList<Entity.UniqueItem>

    handelNameChange = (event: Entity.NameChange) => {
        this.field.list.every(field => {
            if (field.name == event.old) {
                field.name = event.name
                return false
            }
            return true
        })
    }

}
