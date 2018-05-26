
namespace Entity {

    export class NameChange {
        sender: UniqueItem
        name: string

        constructor(sender: UniqueItem, name: string) {
            this.sender = sender
            this.name = name
        }

    }

}
