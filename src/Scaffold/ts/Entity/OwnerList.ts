/// <reference path="./UniqueItem.ts" />
/// <reference path="./UniqueList.ts" />

namespace Entity {

    export class OwnerList<T extends UniqueItem> extends UniqueList<T> {
        owner: Item

        constructor(type: Newable<T>, owner: Item) {
            super(type)
            this.owner = owner
        }

        create(name: string): T {
            return new this.itemType(name, this.owner)
        }

    }

}
