
namespace Entity {

    export class Item {
        [key: string]: any
        ignoreList: string[]

        load(data: Item) {
            for (let key in data) {
                if (data.hasOwnProperty(key)) {
                    if (this.ignoreList.indexOf(key) >= 0) {
                        continue
                    }
                    let item = data[key]
                    if (this[key] && this[key].load) {
                        this[key].load(item)
                        continue
                    }
                    this[key] = item
                }
            }
        }

        toJSON(key: string) {
            let object: { [key: string]: any } = {}
            for (const key of Object.keys(this)) {
                if (this.ignoreList.indexOf(key) >= 0) {
                    continue
                }
                object[key] = this[key]
            }
            return object
        }
    }
    Item.prototype.ignoreList = []

}
