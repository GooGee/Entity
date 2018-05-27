
namespace Entity {

    export class UniqueList<T extends UniqueItem> extends List<T> {
        protected afterNameChange = new Entity.Event<NameChange>()

        find(name: string): T | null {
            let found = null
            this.list.every(item => {
                if (item.name == name) {
                    found = item
                    return false
                }
                return true
            })
            return found
        }

        add(item: T) {
            this.invalidThrow(item.name)

            item.onBeforeNameChange(this.handelBeforeNameChange)
            item.onAfterNameChange(this.handelAfterNameChange)
            this.list.push(item)
        }

        remove(item: T) {
            super.remove(item)
            item.offBeforeNameChange(this.handelBeforeNameChange)
            item.offAfterNameChange(this.handelAfterNameChange)
        }

        merge(array: T[]) {
            array.forEach(item => {
                if (this.find(item.name)) {
                    return
                }
                this.list.push(item)
            })
        }

        private handelBeforeNameChange = (event: NameChange) => {
            this.invalidThrow(event.name)
        }

        private handelAfterNameChange = (event: NameChange) => {
            this.afterNameChange.emit(event)
        }

        invalidThrow(name: string) {
            if (Array.isArray(name.match(/^[a-z_A-Z][a-z_A-Z\d]*$/))) {
                // ok
            } else {
                throw 'Invalid name!'
            }

            if (this.find(name)) {
                throw name + ' already exists!'
            }
        }

        onAfterNameChange(callback: Listener<NameChange>) {
            return this.afterNameChange.on(callback)
        }

        offAfterNameChange(callback: Listener<NameChange>) {
            this.afterNameChange.off(callback)
        }

    }

}
