
namespace Entity {

    export class NameChange {
        sender: UniqueItem
        name: string
        old: string

        constructor(sender: UniqueItem, name: string, old: string) {
            this.sender = sender
            this.name = name
            this.old = old
        }

    }

}
