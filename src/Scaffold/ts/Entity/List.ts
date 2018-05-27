
namespace Entity {

    export class List<T extends Item>
    {
        readonly itemType: Newable<T>
        readonly list: T[] = Array<T>()

        constructor(type: Newable<T>) {
            this.itemType = type
        }

        create(...args: any[]): T {
            return new this.itemType(...args)
        }

        add(item: T) {
            this.list.push(item)
        }

        remove(item: T) {
            let index = this.list.indexOf(item)
            this.list.splice(index, 1)
        }

        moveUp(item: Item) {
            moveUp(this.list, item);
        }
    
        moveDown(item: Item) {
            moveDown(this.list, item);
        }
        
        clear() {
            this.list.length = 0
            this.list.splice(0, 0)
        }

        load(object: any) {
            let array: Item[]
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
                let item = this.create()
                item.load(one)
                this.add(item)
            })
        }

        toJSON(key: string) {
            return {
                list: this.list
            }
        }

    }

}
