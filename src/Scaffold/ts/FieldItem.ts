/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />

class FieldItem extends Entity.UniqueItem {
    fieldList: Entity.UniqueList<Entity.UniqueItem>

    handelNameChange = (event: Entity.NameChange) => {
        this.fieldList.list.every(field => {
            if (field.name == event.old) {
                field.name = event.name
                return false
            }
            return true
        })
    }

}
