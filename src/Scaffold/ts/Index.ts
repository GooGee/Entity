/// <reference path="./Entity/UniqueItem.ts" />
/// <reference path="./Entity/UniqueList.ts" />

class Index extends Entity.UniqueItem {
    type: string
    field = new Entity.UniqueList<Field>(Field)

    constructor(name: string, type: string) {
        super(name);
        this.type = type;
    }

}
