
namespace Entity {

    export class UniqueList<T extends UniqueItem> extends List<T> {

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

        private handelNameChange = (event: NameChange) => {
            this.invalidThrow(event.name)
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

        add(item: T) {
            this.invalidThrow(item.name)

            item.onBeforeNameChange(this.handelNameChange)
            this.list.push(item)
        }

        remove(item: T) {
            super.remove(item)
            item.offBeforeNameChange(this.handelNameChange)
        }

        merge(array: T[]): T[] {
            let list: T[] = []
            array.forEach(item => {
                if (this.find(item.name)) {
                    return
                }
                list.push(item)
            })
            return this.list.concat(list)
        }

        load(object: any) {
            let array: UniqueItem[]
            if (Array.isArray(object)) {
                array = object
            } else {
                if (Array.isArray(object.list)) {
                    array = object.list
                } else {
                    return
                }
            }

            this.clear()
            array.forEach(one => {
                let item = this.create(one.name)
                item.load(one)
                this.add(item)
            })
        }

    }

}
