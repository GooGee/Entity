/// <reference path="./Entity/UniqueItem.ts" />

class FactoryField extends Entity.UniqueItem {
    name: string
    method: string | null = null
    parameters: string | null = null
    property: string | null = null
    raw: string | null = null
    type: string
    unique: boolean = false

    constructor(name: string, type: string) {
        super(name)
        this.type = type
    }
}
