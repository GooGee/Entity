
namespace Entity {

    export class OwnerItem extends UniqueItem {
        owner: Item

        constructor(name: string, owner: Item) {
            super(name)
            this.owner = owner
        }

    }
    OwnerItem.prototype.ignoreList = UniqueItem.prototype.ignoreList.concat(['owner'])

}
