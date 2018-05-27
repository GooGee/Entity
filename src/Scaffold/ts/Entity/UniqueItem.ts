
namespace Entity {

    export class UniqueItem extends Item {
        protected _name: string = ''
        protected beforeNameChange = new Entity.Event<NameChange>()
        protected afterNameChange = new Entity.Event<NameChange>()
        protected static ignoreList = Item.ignoreList.concat(['beforeNameChange', 'afterNameChange'])

        constructor(name: string) {
            super()
            this.name = name
        }

        get name(): string {
            return this._name
        }

        set name(name: string) {
            if (this._name == name) {
                return
            }

            let event = new NameChange(this, name)
            this.beforeNameChange.emit(event)

            this._name = name

            this.afterNameChange.emit(event)
        }

        onBeforeNameChange(callback: Listener<NameChange>) {
            return this.beforeNameChange.on(callback)
        }

        offBeforeNameChange(callback: Listener<NameChange>) {
            this.beforeNameChange.off(callback)
        }

        onAfterNameChange(callback: Listener<NameChange>) {
            return this.afterNameChange.on(callback)
        }

        offAfterNameChange(callback: Listener<NameChange>) {
            this.afterNameChange.off(callback)
        }

    }

}
