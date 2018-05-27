
namespace Entity {

    export class OwnerItem extends UniqueItem {
        owner: Item
        protected static ignoreList = UniqueItem.ignoreList.concat(['owner'])

        constructor(name: string, owner: Item) {
            super(name)
            this.owner = owner
        }

    }

}
